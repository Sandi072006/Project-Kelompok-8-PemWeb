<?php

class Barang {

    public static function getAll($search = '', $kategori = '') {
        $db = getDB();
        $sql = 'SELECT b.*, COALESCE(s.perusahaan, b.supplier, "-") AS nama_supplier
                FROM barang b
                LEFT JOIN supplier s ON s.id = b.supplier_id
                WHERE 1=1';
        $params = [];

        if ($search !== '') {
            $sql .= ' AND (b.kode LIKE ? OR b.nama LIKE ? OR b.kategori LIKE ? OR b.merek LIKE ? OR COALESCE(s.perusahaan, b.supplier, "") LIKE ?)';
            $keyword = '%' . $search . '%';
            $params = array_merge($params, [$keyword, $keyword, $keyword, $keyword, $keyword]);
        }

        if ($kategori !== '') {
            $sql .= ' AND b.kategori = ?';
            $params[] = $kategori;
        }

        $sql .= ' ORDER BY b.kode ASC';
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function getKategoriList() {
        $db = getDB();
        return $db->query('SELECT DISTINCT kategori FROM barang WHERE kategori IS NOT NULL AND kategori <> "" ORDER BY kategori ASC')->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function findById($id) {
        $db = getDB();
        $stmt = $db->prepare(
            'SELECT b.*, COALESCE(s.perusahaan, b.supplier, "-") AS nama_supplier
             FROM barang b
             LEFT JOIN supplier s ON s.id = b.supplier_id
             WHERE b.id = ?
             LIMIT 1'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

   public static function getStokRendah() {
    $db = getDB();

    $stmt = $db->query(
        'SELECT b.*, COALESCE(s.perusahaan, b.supplier, "-") AS nama_supplier
         FROM barang b
         LEFT JOIN supplier s ON s.id = b.supplier_id
         WHERE CAST(COALESCE(b.stok,0) AS UNSIGNED) <= 30
         ORDER BY CAST(COALESCE(b.stok,0) AS UNSIGNED) ASC'
    );

    return $stmt->fetchAll();
}

    public static function create($data) {
        $db = getDB();
        $supplierName = self::getSupplierName($data['supplier_id'] ?? null);
        $status = self::statusFromStock($data['stok'] ?? 0, $data['stok_minimum'] ?? 0);

        $stmt = $db->prepare(
            'INSERT INTO barang
             (kode, nama, kategori, merek, supplier, supplier_id, stok, satuan, stok_minimum, harga_beli, harga_jual, status, deskripsi)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        return $stmt->execute([
            $data['kode'],
            $data['nama'],
            $data['kategori'],
            $data['merek'] ?? '',
            $supplierName,
            $data['supplier_id'] ?: null,
            $data['stok'],
            $data['satuan'] ?? '',
            $data['stok_minimum'] ?? 0,
            $data['harga_beli'],
            $data['harga_jual'],
            $status,
            $data['deskripsi'] ?? '',
        ]);
    }

    public static function update($id, $data) {
        $db = getDB();
        $supplierName = self::getSupplierName($data['supplier_id'] ?? null);
        $status = self::statusFromStock($data['stok'] ?? 0, $data['stok_minimum'] ?? 0);

        $stmt = $db->prepare(
            'UPDATE barang SET
             kode = ?, nama = ?, kategori = ?, merek = ?, supplier = ?, supplier_id = ?,
             stok = ?, satuan = ?, stok_minimum = ?, harga_beli = ?, harga_jual = ?,
             status = ?, deskripsi = ?
             WHERE id = ?'
        );

        return $stmt->execute([
            $data['kode'],
            $data['nama'],
            $data['kategori'],
            $data['merek'] ?? '',
            $supplierName,
            $data['supplier_id'] ?: null,
            $data['stok'],
            $data['satuan'] ?? '',
            $data['stok_minimum'] ?? 0,
            $data['harga_beli'],
            $data['harga_jual'],
            $status,
            $data['deskripsi'] ?? '',
            $id,
        ]);
    }

    public static function updateStockStatus($id) {
        $barang = self::findById($id);
        if (!$barang) return false;
        $db = getDB();
        $status = self::statusFromStock($barang['stok'] ?? 0, $barang['stok_minimum'] ?? 0);
        $stmt = $db->prepare('UPDATE barang SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare('DELETE FROM barang WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function count() {
        $db = getDB();
        return $db->query('SELECT COUNT(*) FROM barang')->fetchColumn();
    }

    private static function getSupplierName($supplierId) {
        if (empty($supplierId)) {
            return null;
        }

        $db = getDB();
        $stmt = $db->prepare('SELECT perusahaan FROM supplier WHERE id = ? LIMIT 1');
        $stmt->execute([$supplierId]);
        return $stmt->fetchColumn() ?: null;
    }

    private static function statusFromStock($stok, $stokMinimum) {
        $stok = (int) $stok;
        $stokMinimum = (int) $stokMinimum;

        if ($stok <= 0) {
            return 'Habis';
        }

        return $stok <= $stokMinimum ? 'Hampir habis' : 'Tersedia';
    }
}
