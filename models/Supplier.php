<?php

class Supplier {

    public static function getAll() {
        $db = getDB();
        $stmt = $db->query(
            "SELECT
                id,
                nama_supplier AS perusahaan,
                nama AS nama,
                kontak AS telepon,
                kontak AS kontak,
                alamat,
                email,
                kategori,
                status,
                catatan,
                created_at
             FROM supplier
             ORDER BY nama_supplier ASC"
        );
        return $stmt->fetchAll();
    }

    public static function search($keyword = '', $status = '') {
        $db = getDB();
        $sql = "SELECT
                    id,
                    nama_supplier AS perusahaan,
                    nama AS nama,
                    kontak AS telepon,
                    kontak AS kontak,
                    alamat,
                    email,
                    kategori,
                    status,
                    catatan,
                    created_at
                FROM supplier
                WHERE 1=1";
        $params = [];

        $keyword = trim((string) $keyword);
        $status = trim((string) $status);

        if ($keyword !== '') {
            $sql .= " AND (nama_supplier LIKE ? OR nama LIKE ? OR kontak LIKE ? OR alamat LIKE ? OR email LIKE ?)";
            $like = '%' . $keyword . '%';
            array_push($params, $like, $like, $like, $like, $like);
        }

        if ($status !== '') {
            $sql .= " AND status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY nama_supplier ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function findById($id) {
        $db = getDB();
        $stmt = $db->prepare(
            "SELECT
                id,
                nama_supplier AS perusahaan,
                nama AS nama,
                kontak AS telepon,
                kontak AS kontak,
                alamat,
                email,
                kategori,
                status,
                catatan,
                created_at
             FROM supplier
             WHERE id = ?
             LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function getAktif() {
        $db = getDB();
        $stmt = $db->query(
            "SELECT
                id,
                nama_supplier AS perusahaan,
                nama AS nama,
                kontak AS telepon,
                kontak AS kontak,
                alamat,
                email,
                kategori,
                status,
                catatan,
                created_at
             FROM supplier
             WHERE status = 'aktif'
             ORDER BY nama_supplier ASC"
        );
        return $stmt->fetchAll();
    }

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare(
            "INSERT INTO supplier
             (nama_supplier, nama, kontak, email, alamat, kategori, status, catatan)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $nama_supplier = isset($data['perusahaan']) && $data['perusahaan'] !== '' ? $data['perusahaan'] : (isset($data['nama']) ? $data['nama'] : '');
        $nama          = isset($data['nama']) ? $data['nama'] : '';
        $kontak        = isset($data['telepon']) ? $data['telepon'] : '';
        $email         = isset($data['email']) ? $data['email'] : '';
        $alamat        = isset($data['alamat']) ? $data['alamat'] : '';
        $kategori      = isset($data['kategori']) ? $data['kategori'] : '';
        $status        = isset($data['status']) ? $data['status'] : 'aktif';
        $catatan       = isset($data['catatan']) ? $data['catatan'] : '';

        return $stmt->execute([
            $nama_supplier,
            $nama,
            $kontak,
            $email,
            $alamat,
            $kategori,
            $status,
            $catatan,
        ]);
    }

    public static function update($id, $data) {
        $db = getDB();
        $stmt = $db->prepare(
            "UPDATE supplier SET
             nama_supplier = ?, nama = ?, kontak = ?, email = ?, alamat = ?, kategori = ?, status = ?, catatan = ?
             WHERE id = ?"
        );

        // Ambil data dengan aman
        $nama_supplier = isset($data['perusahaan']) && $data['perusahaan'] !== '' ? $data['perusahaan'] : (isset($data['nama']) ? $data['nama'] : '');
        $nama          = isset($data['nama']) ? $data['nama'] : '';
        $kontak        = isset($data['telepon']) ? $data['telepon'] : '';
        $email         = isset($data['email']) ? $data['email'] : '';
        $alamat        = isset($data['alamat']) ? $data['alamat'] : '';
        $kategori      = isset($data['kategori']) ? $data['kategori'] : '';
        $status        = isset($data['status']) ? $data['status'] : 'aktif';
        $catatan       = isset($data['catatan']) ? $data['catatan'] : '';

        return $stmt->execute([
            $nama_supplier,
            $nama,
            $kontak,
            $email,
            $alamat,
            $kategori,
            $status,
            $catatan,
            $id,
        ]);
    }

    public static function delete($id) {
        return self::deactivate($id);
    }

    public static function deactivate($id) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE supplier SET status = 'nonaktif' WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function count() {
        $db = getDB();
        return $db->query("SELECT COUNT(*) FROM supplier")->fetchColumn();
    }

    public static function countAktif() {
        $db = getDB();
        return $db->query("SELECT COUNT(*) FROM supplier WHERE status = 'aktif'")->fetchColumn();
    }
}
