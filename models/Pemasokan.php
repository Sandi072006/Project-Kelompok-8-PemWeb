<?php

class Pemasokan {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query(
            'SELECT p.*,
                    COALESCE(b.nama, p.barang, "-") AS nama_barang,
                    COALESCE(s.perusahaan, p.supplier, "-") AS nama_supplier
             FROM pemasokan p
             LEFT JOIN barang b ON b.id = p.barang_id
             LEFT JOIN supplier s ON s.id = p.supplier_id
             ORDER BY p.tanggal DESC, p.id DESC'
        );
        return $stmt->fetchAll();
    }



    public static function search($keyword = '', $supplierId = '') {
        $db = getDB();
        $sql = 'SELECT p.*,
                    COALESCE(b.nama, p.barang, "-") AS nama_barang,
                    COALESCE(s.perusahaan, p.supplier, "-") AS nama_supplier
                FROM pemasokan p
                LEFT JOIN barang b ON b.id = p.barang_id
                LEFT JOIN supplier s ON s.id = p.supplier_id
                WHERE 1=1';
        $params = [];

        $keyword = trim((string) $keyword);
        $supplierId = trim((string) $supplierId);

        if ($keyword !== '') {
            $sql .= ' AND (p.kode LIKE ? OR p.tanggal LIKE ? OR COALESCE(b.nama, p.barang) LIKE ? OR COALESCE(s.perusahaan, p.supplier) LIKE ? OR p.catatan LIKE ? OR p.status LIKE ?)';
            $like = '%' . $keyword . '%';
            array_push($params, $like, $like, $like, $like, $like, $like);
        }

        if ($supplierId !== '') {
            $sql .= ' AND p.supplier_id = ?';
            $params[] = $supplierId;
        }

        $sql .= ' ORDER BY p.tanggal DESC, p.id DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function findById($id) {
        $db = getDB();
        $stmt = $db->prepare(
            'SELECT p.*,
                    COALESCE(b.nama, p.barang, "-") AS nama_barang,
                    COALESCE(s.perusahaan, p.supplier, "-") AS nama_supplier
             FROM pemasokan p
             LEFT JOIN barang b ON b.id = p.barang_id
             LEFT JOIN supplier s ON s.id = p.supplier_id
             WHERE p.id = ?
             LIMIT 1'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function getBySupplier($supplierId) {
        $db = getDB();
        $stmt = $db->prepare(
            'SELECT p.*,
                    COALESCE(b.nama, p.barang, "-") AS nama_barang,
                    COALESCE(s.perusahaan, p.supplier, "-") AS nama_supplier
             FROM pemasokan p
             LEFT JOIN barang b ON b.id = p.barang_id
             LEFT JOIN supplier s ON s.id = p.supplier_id
             WHERE p.supplier_id = ?
             ORDER BY p.tanggal DESC, p.id DESC'
        );
        $stmt->execute([$supplierId]);
        return $stmt->fetchAll();
    }

    public static function create($data) {
        $db = getDB();
        $db->beginTransaction();

        try {
            $barang = self::findBarang($data['barang_id']);
            $supplier = self::findSupplier($data['supplier_id']);
            $kode = self::generateKode();

            $stmt = $db->prepare(
                'INSERT INTO pemasokan
                 (kode, barang, supplier, supplier_id, barang_id, jumlah, harga_beli, tanggal, status, catatan, user_id)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );

            $stmt->execute([
                $kode,
                $barang['nama'] ?? null,
                $supplier['perusahaan'] ?? null,
                $data['supplier_id'],
                $data['barang_id'],
                $data['jumlah'],
                $data['harga_beli'],
                $data['tanggal'],
                'Selesai',
                $data['catatan'] ?? '',
                $data['user_id'] ?? null,
            ]);

            $updateStok = $db->prepare(
                'UPDATE barang
                 SET stok = CAST(COALESCE(stok, 0) AS UNSIGNED) + ?
                 WHERE id = ?'
            );
            $updateStok->execute([(int) $data['jumlah'], $data['barang_id']]);

            $db->commit();
            return true;
        } catch (Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare('DELETE FROM pemasokan WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function count() {
        $db = getDB();
        return $db->query('SELECT COUNT(*) FROM pemasokan')->fetchColumn();
    }

    private static function findBarang($id) {
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM barang WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: [];
    }

    private static function findSupplier($id) {
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM supplier WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: [];
    }

    private static function generateKode() {
        $db = getDB();
        $lastId = (int) $db->query('SELECT COALESCE(MAX(id), 0) FROM pemasokan')->fetchColumn();
        return 'PM-' . date('Ymd') . '-' . str_pad((string) ($lastId + 1), 4, '0', STR_PAD_LEFT);
    }
}
