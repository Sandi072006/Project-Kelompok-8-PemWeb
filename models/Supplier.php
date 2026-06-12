<?php

class Supplier {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query(
            'SELECT *, COALESCE(telepon, kontak) AS telepon
             FROM supplier
             ORDER BY perusahaan ASC'
        );
        return $stmt->fetchAll();
    }



    public static function search($keyword = '', $status = '') {
        $db = getDB();
        $sql = 'SELECT *, COALESCE(telepon, kontak) AS telepon FROM supplier WHERE 1=1';
        $params = [];

        $keyword = trim((string) $keyword);
        $status = trim((string) $status);

        if ($keyword !== '') {
            $sql .= ' AND (nama LIKE ? OR perusahaan LIKE ? OR COALESCE(telepon, kontak) LIKE ? OR email LIKE ? OR alamat LIKE ? OR kategori LIKE ?)';
            $like = '%' . $keyword . '%';
            array_push($params, $like, $like, $like, $like, $like, $like);
        }

        if ($status !== '') {
            $sql .= ' AND LOWER(status) = LOWER(?)';
            $params[] = $status;
        }

        $sql .= ' ORDER BY perusahaan ASC';
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function findById($id) {
        $db = getDB();
        $stmt = $db->prepare(
            'SELECT *, COALESCE(telepon, kontak) AS telepon
             FROM supplier
             WHERE id = ?
             LIMIT 1'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function getAktif() {
        $db = getDB();
        $stmt = $db->query(
            "SELECT *, COALESCE(telepon, kontak) AS telepon
             FROM supplier
             WHERE status = 'aktif'
             ORDER BY perusahaan ASC"
        );
        return $stmt->fetchAll();
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare(
            'INSERT INTO supplier
             (nama, perusahaan, kontak, telepon, email, alamat, kategori, status, catatan)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        return $stmt->execute([
            $data['nama'],
            $data['perusahaan'],
            $data['telepon'] ?? '',
            $data['telepon'] ?? '',
            $data['email'] ?? '',
            $data['alamat'] ?? '',
            $data['kategori'] ?? '',
            $data['status'] ?? 'aktif',
            $data['catatan'] ?? '',
        ]);
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare(
            'UPDATE supplier SET
             nama = ?, perusahaan = ?, kontak = ?, telepon = ?, email = ?,
             alamat = ?, kategori = ?, status = ?, catatan = ?
             WHERE id = ?'
        );

        return $stmt->execute([
            $data['nama'],
            $data['perusahaan'],
            $data['telepon'] ?? '',
            $data['telepon'] ?? '',
            $data['email'] ?? '',
            $data['alamat'] ?? '',
            $data['kategori'] ?? '',
            $data['status'] ?? 'aktif',
            $data['catatan'] ?? '',
            $id,
        ]);
    }

    public static function delete($id) {
        $db = getDB();
        $stmt = $db->prepare('DELETE FROM supplier WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function count() {
        $db = getDB();
        return $db->query('SELECT COUNT(*) FROM supplier')->fetchColumn();
    }

    public static function countAktif() {
        $db = getDB();
        return $db->query("SELECT COUNT(*) FROM supplier WHERE status='aktif'")->fetchColumn();
    }
}
