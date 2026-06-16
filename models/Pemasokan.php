<?php

class Pemasokan {

    public static function getTerbaru($limit = 5) {
        $db = getDB();
    
        $limit = (int) $limit;
        if ($limit <= 0) {
            $limit = 5;
        }
    
        $stmt = $db->query(
            "SELECT
                p.id,
                p.kode,
                p.jumlah,
                p.tanggal_pemasokan AS tanggal,
                p.status,
                COALESCE(b.kode, '-') AS kode_barang,
                COALESCE(b.nama_barang, '-') AS nama_barang,
                COALESCE(b.satuan, '') AS satuan,
                COALESCE(s.nama_supplier, '-') AS nama_supplier
             FROM pemasokan p
             LEFT JOIN barang b ON b.id = p.barang_id
             LEFT JOIN supplier s ON s.id = p.supplier_id
             WHERE COALESCE(p.status, 'aktif') = 'aktif'
             ORDER BY p.tanggal_pemasokan DESC, p.id DESC
             LIMIT $limit"
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
                p.id,
                p.kode,
                p.jumlah,
                p.tanggal_pemasokan AS tanggal,
                p.harga_beli,
                p.catatan,
                p.status,
                COALESCE(s.nama_supplier, '-') AS nama_supplier
             FROM pemasokan p
             LEFT JOIN supplier s ON s.id = p.supplier_id
             WHERE p.barang_id = ?
             ORDER BY p.tanggal_pemasokan DESC, p.id DESC
             LIMIT $limit"
        );
    
        $stmt->execute([$barangId]);
        return $stmt->fetchAll();
    }

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query(
            "SELECT
                    p.id,
                    p.barang_id,
                    p.supplier_id,
                    p.jumlah,
                    p.tanggal_pemasokan AS tanggal,
                    p.tanggal_pemasokan,
                    p.catatan,
                    p.created_at,
                    p.kode,
                    p.harga_beli,
                    (p.jumlah * p.harga_beli) AS total,
                    p.user_id,
                    p.status,
                    p.cancelled_by,
                    p.cancelled_at,
                    COALESCE(b.nama_barang, '-') AS nama_barang,
                    COALESCE(s.nama_supplier, '-') AS nama_supplier,
                    COALESCE(u.nama, 'Admin') AS petugas
             FROM pemasokan p
             LEFT JOIN barang b ON b.id = p.barang_id
             LEFT JOIN supplier s ON s.id = p.supplier_id
             LEFT JOIN users u ON u.id = p.user_id
             ORDER BY p.tanggal_pemasokan DESC, p.id DESC"
        );
        return $stmt->fetchAll();
    }

    public static function search($keyword = '', $supplierId = '') {
        $db = getDB();
        $sql = "SELECT
                    p.id,
                    p.barang_id,
                    p.supplier_id,
                    p.jumlah,
                    p.tanggal_pemasokan AS tanggal,
                    p.tanggal_pemasokan,
                    p.catatan,
                    p.created_at,
                    p.kode,
                    p.harga_beli,
                    (p.jumlah * p.harga_beli) AS total,
                    p.user_id,
                    p.status,
                    p.cancelled_by,
                    p.cancelled_at,
                    COALESCE(b.nama_barang, '-') AS nama_barang,
                    COALESCE(s.nama_supplier, '-') AS nama_supplier,
                    COALESCE(u.nama, 'Admin') AS petugas
                FROM pemasokan p
                LEFT JOIN barang b ON b.id = p.barang_id
                LEFT JOIN supplier s ON s.id = p.supplier_id
                LEFT JOIN users u ON u.id = p.user_id
                WHERE 1=1";
        $params = [];

        $keyword = trim((string) $keyword);
        $supplierId = trim((string) $supplierId);

        if ($keyword !== '') {
            $sql .= " AND (p.tanggal_pemasokan LIKE ? OR p.kode LIKE ? OR COALESCE(b.nama_barang, '-') LIKE ? OR COALESCE(s.nama_supplier, '-') LIKE ? OR p.catatan LIKE ?)";
            $like = '%' . $keyword . '%';
            array_push($params, $like, $like, $like, $like, $like);
        }

        if ($supplierId !== '') {
            $sql .= " AND p.supplier_id = ?";
            $params[] = $supplierId;
        }

        $sql .= " ORDER BY p.tanggal_pemasokan DESC, p.id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function findById($id) {
        $db = getDB();
    
        $stmt = $db->prepare(
            "SELECT
                p.id,
                p.kode,
                p.barang_id,
                p.supplier_id,
                p.jumlah,
                p.tanggal_pemasokan AS tanggal,
                p.tanggal_pemasokan,
                p.harga_beli,
                (p.jumlah * p.harga_beli) AS total,
                p.catatan,
                p.user_id,
                p.status,
                p.cancelled_by,
                p.cancelled_at,
                p.created_at,
    
                COALESCE(b.kode, '-') AS kode_barang,
                COALESCE(b.nama_barang, '-') AS nama_barang,
                COALESCE(b.kategori, '-') AS kategori_barang,
                COALESCE(b.merek, '-') AS merek_barang,
                COALESCE(b.satuan, '') AS satuan,
                COALESCE(b.stok, 0) AS stok_saat_ini,
                COALESCE(b.stok_minimum, 0) AS stok_minimum,
                COALESCE(b.harga_jual, 0) AS harga_jual,
    
                COALESCE(s.nama_supplier, '-') AS nama_supplier,
                COALESCE(s.nama, '-') AS nama_penanggung_jawab,
                COALESCE(s.kontak, '-') AS kontak_supplier,
                COALESCE(s.email, '-') AS email_supplier,
                COALESCE(s.alamat, '-') AS alamat_supplier,
    
                COALESCE(u.nama, 'Admin') AS petugas,
                COALESCE(cu.nama, '-') AS dibatalkan_oleh
             FROM pemasokan p
             LEFT JOIN barang b ON b.id = p.barang_id
             LEFT JOIN supplier s ON s.id = p.supplier_id
             LEFT JOIN users u ON u.id = p.user_id
             LEFT JOIN users cu ON cu.id = p.cancelled_by
             WHERE p.id = ?
             LIMIT 1"
        );
    
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function getBySupplier($supplierId) {
        $db = getDB();
    
        $stmt = $db->prepare(
            "SELECT
                p.id,
                p.kode,
                p.barang_id,
                p.supplier_id,
                p.jumlah,
                p.tanggal_pemasokan AS tanggal,
                p.tanggal_pemasokan,
                p.harga_beli,
                (p.jumlah * p.harga_beli) AS total,
                p.catatan,
                p.status,
                p.created_at,
    
                COALESCE(b.kode, '-') AS kode_barang,
                COALESCE(b.nama_barang, '-') AS nama_barang,
                COALESCE(b.satuan, '') AS satuan,
    
                COALESCE(s.nama_supplier, '-') AS nama_supplier,
                COALESCE(u.nama, 'Admin') AS petugas
             FROM pemasokan p
             LEFT JOIN barang b ON b.id = p.barang_id
             LEFT JOIN supplier s ON s.id = p.supplier_id
             LEFT JOIN users u ON u.id = p.user_id
             WHERE p.supplier_id = ?
             ORDER BY p.tanggal_pemasokan DESC, p.id DESC"
        );
    
        $stmt->execute([$supplierId]);
        return $stmt->fetchAll();
    }

    public static function create($data) {
        $db = getDB();
        
        // Memulai transaksi database agar data aman (jika ada error, tidak ada yang tersimpan)
        $db->beginTransaction();

        try {
            // Pastikan jumlah adalah angka
            $jumlah = isset($data['jumlah']) ? (int) $data['jumlah'] : 0;
            if ($jumlah <= 0) {
                throw new Exception('Jumlah pemasokan harus lebih dari 0.');
            }

            // Cari data barang di database
            $barang_id = isset($data['barang_id']) ? $data['barang_id'] : null;
            $barang = self::findBarang($barang_id);
            
            // Cek apakah status aktif barang tersebut adalah 'nonaktif'
            $status_aktif_barang = isset($barang['status_aktif']) ? $barang['status_aktif'] : '';
            if (!$barang || $status_aktif_barang === 'nonaktif') {
                throw new Exception('Barang tidak ditemukan atau sudah dinonaktifkan.');
            }

            // Cari data supplier di database
            $supplier_id = isset($data['supplier_id']) ? $data['supplier_id'] : null;
            $supplier = self::findSupplier($supplier_id);
            
            // Cek apakah status supplier tersebut adalah 'nonaktif'
            $status_supplier = isset($supplier['status']) ? $supplier['status'] : '';
            if (!$supplier || $status_supplier === 'nonaktif') {
                throw new Exception('Supplier tidak ditemukan atau sudah dinonaktifkan.');
            }

            // Buat kode otomatis jika tidak ada kode yang diberikan
            $kode = self::generateKode();

            // Siapkan penyisipan ke tabel pemasokan
            $stmt = $db->prepare(
                "INSERT INTO pemasokan
                 (kode, barang_id, supplier_id, jumlah, tanggal_pemasokan, harga_beli, catatan, user_id)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );

            $tanggal    = isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d');
            $harga_beli = isset($data['harga_beli']) ? $data['harga_beli'] : 0;
            $catatan    = isset($data['catatan']) ? $data['catatan'] : '';
            $user_id    = isset($data['user_id']) ? $data['user_id'] : null;

            $stmt->execute([
                $kode,
                $barang_id,
                $supplier_id,
                $jumlah,
                $tanggal,
                $harga_beli,
                $catatan,
                $user_id,
            ]);

            $updateStok = $db->prepare(
                "UPDATE barang
                 SET stok = stok + ?
                 WHERE id = ?"
            );
            $updateStok->execute([(int) $data['jumlah'], $data['barang_id']]);

            // Update status stok
            Barang::updateStockStatus($data['barang_id']);

            $db->commit();
            return true;
        } catch (Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function delete($id) {
        throw new Exception("Transaksi pemasokan tidak boleh dihapus. Gunakan fitur batalkan.");
    }

    public static function cancel($id, $userId) {
        $db = getDB();
        $db->beginTransaction();

        try {
            $stmt = $db->prepare("SELECT * FROM pemasokan WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            $row = $stmt->fetch();

            if (!$row || $row['status'] === 'dibatalkan') {
                $db->commit();
                return true;
            }

            // rollback stock: decrease stock by the amount that was supplied
            $restore = $db->prepare("UPDATE barang SET stok = stok - ? WHERE id = ?");
            $restore->execute([(int)$row['jumlah'], $row['barang_id']]);

            // update status stok
            Barang::updateStockStatus($row['barang_id']);

            $update = $db->prepare("UPDATE pemasokan SET status = 'dibatalkan', cancelled_by = ?, cancelled_at = NOW() WHERE id = ?");
            $update->execute([$userId, $id]);

            $db->commit();
            return true;
        } catch (Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function count() {
        $db = getDB();
        return $db->query("SELECT COUNT(*) FROM pemasokan")->fetchColumn();
    }

    private static function findBarang($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM barang WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: [];
    }

    private static function findSupplier($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM supplier WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: [];
    }

    private static function generateKode() {
    $db = getDB();

    $stmt = $db->query(
        "SELECT COALESCE(
            MAX(CAST(REPLACE(kode, 'SO-', '') AS UNSIGNED)),
            0
        ) AS nomor_terakhir
        FROM stock_out
        WHERE kode REGEXP '^SO-[0-9]+$'"
    );

    $nomorTerakhir = (int) $stmt->fetchColumn();
    $nomorBaru = $nomorTerakhir + 1;

    return 'SO-' . str_pad((string)$nomorBaru, 3, '0', STR_PAD_LEFT);
    }
}
