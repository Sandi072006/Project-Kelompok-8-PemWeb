<?php

class StockOut {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query(
            'SELECT so.*, b.nama AS nama_barang, b.kode AS kode_barang, b.satuan
             FROM stock_out so
             LEFT JOIN barang b ON b.id = so.barang_id
             ORDER BY so.tanggal DESC, so.id DESC'
        );
        return $stmt->fetchAll();
    }

    public static function create($data) {
        $db = getDB();
        $db->beginTransaction();

        try {
            $stmt = $db->prepare('SELECT * FROM barang WHERE id = ? LIMIT 1 FOR UPDATE');
            $stmt->execute([$data['barang_id']]);
            $barang = $stmt->fetch();

            if (!$barang) {
                throw new Exception('Barang tidak ditemukan.');
            }

            $jumlah = (int) ($data['jumlah'] ?? 0);
            if ($jumlah <= 0) {
                throw new Exception('Jumlah stock out harus lebih dari 0.');
            }

            if ((int)$barang['stok'] < $jumlah) {
                throw new Exception('Stok tidak cukup. Stok tersedia hanya ' . (int)$barang['stok'] . ' ' . ($barang['satuan'] ?? ''));
            }

            $kode = self::generateKode();
            $insert = $db->prepare(
                'INSERT INTO stock_out (kode, barang_id, jumlah, tanggal, tujuan, catatan, user_id)
                 VALUES (?, ?, ?, ?, ?, ?, ?)'
            );
            $insert->execute([
                $kode,
                $data['barang_id'],
                $jumlah,
                $data['tanggal'],
                $data['tujuan'] ?? '',
                $data['catatan'] ?? '',
                $data['user_id'] ?? null,
            ]);

            $update = $db->prepare('UPDATE barang SET stok = CAST(COALESCE(stok, 0) AS UNSIGNED) - ? WHERE id = ?');
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
        $db = getDB();
        $db->beginTransaction();

        try {
            $stmt = $db->prepare('SELECT * FROM stock_out WHERE id = ? LIMIT 1');
            $stmt->execute([$id]);
            $row = $stmt->fetch();

            if (!$row) {
                $db->commit();
                return true;
            }

            $restore = $db->prepare('UPDATE barang SET stok = CAST(COALESCE(stok, 0) AS UNSIGNED) + ? WHERE id = ?');
            $restore->execute([(int)$row['jumlah'], $row['barang_id']]);

            $delete = $db->prepare('DELETE FROM stock_out WHERE id = ?');
            $delete->execute([$id]);

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
        return $db->query('SELECT COUNT(*) FROM stock_out')->fetchColumn();
    }

    private static function generateKode() {
        $db = getDB();
        $lastId = (int) $db->query('SELECT COALESCE(MAX(id), 0) FROM stock_out')->fetchColumn();
        return 'SO-' . date('Ymd') . '-' . str_pad((string) ($lastId + 1), 4, '0', STR_PAD_LEFT);
    }
}
