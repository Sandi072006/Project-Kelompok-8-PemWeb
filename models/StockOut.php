<?php

class StockOut {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query(
            "SELECT
                so.id,
                so.barang_id,
                so.jumlah,
                so.tanggal_keluar AS tanggal,
                so.catatan,
                so.keterangan,
                so.created_at,
                so.kode,
                so.tujuan,
                so.user_id,
                so.status,
                so.cancelled_by,
                so.cancelled_at,
                COALESCE(b.nama_barang, '-') AS nama_barang,
                COALESCE(b.kode, '-') AS kode_barang,
                COALESCE(b.satuan, '') AS satuan
             FROM stock_out so
             LEFT JOIN barang b ON b.id = so.barang_id
             ORDER BY so.tanggal_keluar DESC, so.id DESC"
        );
        return $stmt->fetchAll();
    }

    public static function getByBarang($barangId, $limit = 5) {
        $db = getDB();
    
        $limit = (int) $limit;
        if ($limit <= 0) {
            $limit = 5;
        }
    
        $stmt = $db->prepare(
            "SELECT
                so.id,
                so.kode,
                so.jumlah,
                so.tanggal_keluar AS tanggal,
                so.tujuan,
                so.catatan,
                so.keterangan,
                so.status
             FROM stock_out so
             WHERE so.barang_id = ?
             ORDER BY so.tanggal_keluar DESC, so.id DESC
             LIMIT $limit"
        );
    
        $stmt->execute([$barangId]);
        return $stmt->fetchAll();
    }

    // ── Menyimpan Transaksi Stock Out Baru ──
    public static function create($data) {
        $db = getDB();
        
        $db->beginTransaction();

        try {
            $stmt = $db->prepare("SELECT * FROM barang WHERE id = ? LIMIT 1 FOR UPDATE");
            $stmt->execute([$data['barang_id']]);
            $barang = $stmt->fetch();

            if (!$barang) {
                throw new Exception('Barang tidak ditemukan.');
            }
            
            $status_aktif = isset($barang['status_aktif']) ? $barang['status_aktif'] : '';
            if ($status_aktif === 'nonaktif') {
                throw new Exception('Barang sudah dinonaktifkan.');
            }

            $jumlah = isset($data['jumlah']) ? (int) $data['jumlah'] : 0;
            if ($jumlah <= 0) {
                throw new Exception('Jumlah stock out harus lebih dari 0.');
            }

            $stok_barang = (int)$barang['stok'];
            $satuan = isset($barang['satuan']) ? $barang['satuan'] : '';
            if ($stok_barang < $jumlah) {
                throw new Exception('Stok tidak cukup. Stok tersedia hanya ' . $stok_barang . ' ' . $satuan);
            }

            $kode       = isset($data['kode']) ? $data['kode'] : self::generateKode();
            $tujuan     = isset($data['tujuan']) ? $data['tujuan'] : '';
            $catatan    = isset($data['catatan']) ? $data['catatan'] : '';
            
            if ($catatan) {
                $keterangan = trim($tujuan . ' - ' . $catatan);
            } else {
                $keterangan = trim($tujuan);
            }

            $user_id = isset($data['user_id']) ? $data['user_id'] : null;
            $tanggal = isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d');

            $insert = $db->prepare(
                "INSERT INTO stock_out (kode, barang_id, jumlah, tanggal_keluar, tujuan, catatan, keterangan, user_id)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $insert->execute([
                $kode,
                $data['barang_id'],
                $jumlah,
                $tanggal,
                $tujuan,
                $catatan,
                $keterangan,
                $user_id,
            ]);

            $update = $db->prepare("UPDATE barang SET stok = stok - ? WHERE id = ?");
            $update->execute([$jumlah, $data['barang_id']]);

            Barang::updateStockStatus($data['barang_id']);

            $db->commit();
            return true;
        } catch (Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function delete($id) {
        throw new Exception("Transaksi stock out tidak boleh dihapus. Gunakan fitur batalkan.");
    }

    public static function cancel($id, $userId) {
        $db = getDB();
        $db->beginTransaction();

        try {
            $stmt = $db->prepare("SELECT * FROM stock_out WHERE id = ? LIMIT 1 FOR UPDATE");
            $stmt->execute([$id]);
            $row = $stmt->fetch();

            if (!$row || $row['status'] === 'dibatalkan') {
                $db->commit();
                return true;
            }

            $restore = $db->prepare("UPDATE barang SET stok = stok + ? WHERE id = ?");
            $restore->execute([(int)$row['jumlah'], $row['barang_id']]);

            $update = $db->prepare("UPDATE stock_out SET status = 'dibatalkan', cancelled_by = ?, cancelled_at = NOW() WHERE id = ?");
            $update->execute([$userId, $id]);

            Barang::updateStockStatus($row['barang_id']);

            $db->commit();
            return true;
        } catch (Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function count() {
        $db = getDB();
        return $db->query("SELECT COUNT(*) FROM stock_out")->fetchColumn();
    }

    private static function generateKode() {
        $db = getDB();
        $lastId = (int) $db->query("SELECT COALESCE(MAX(id), 0) FROM stock_out")->fetchColumn();
        return 'SO-' . date('Ymd') . '-' . str_pad((string) ($lastId + 1), 4, '0', STR_PAD_LEFT);
    }
}
