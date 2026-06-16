<?php
class Barang {

    public static function getAll($search = '', $kategori = '') {
        $db = getDB();
        $sql = "SELECT
                    b.id,
                    b.nama_barang AS nama,
                    b.nama_barang,
                    b.kategori,
                    b.stok,
                    b.created_at,
                    b.harga_beli,
                    b.harga_jual,
                    b.kode,
                    b.merek,
                    COALESCE(s.nama_supplier, '-') AS nama_supplier,
                    b.satuan,
                    b.stok_minimum,
                    b.status,
                    b.status_aktif,
                    b.deskripsi,
                    b.supplier_id
                FROM barang b
                LEFT JOIN supplier s ON s.id = b.supplier_id
                WHERE b.status_aktif = 'aktif'";
        $params = [];

        if ($search !== '') {
            $sql .= " AND (b.nama_barang LIKE ? OR b.kategori LIKE ? OR b.kode LIKE ? OR b.merek LIKE ? OR s.nama_supplier LIKE ?)";
            $keyword = '%' . $search . '%';
            $params = array_merge($params, [$keyword, $keyword, $keyword, $keyword, $keyword]);
        }

        if ($kategori !== '') {
            $sql .= " AND b.kategori = ?";
            $params[] = $kategori;
        }

        $sql .= " ORDER BY CAST(REPLACE(b.kode, 'BRG-', '') AS UNSIGNED) DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function getKategoriList() {
        $db = getDB();
        return $db->query("SELECT DISTINCT kategori FROM barang WHERE kategori IS NOT NULL AND kategori <> '' ORDER BY kategori ASC")->fetchAll(PDO::FETCH_COLUMN);
    }
    public static function findById($id) {
        $db = getDB();
        $stmt = $db->prepare(
            "SELECT
                b.id,
                b.nama_barang AS nama,
                b.nama_barang,
                b.kategori,
                b.stok,
                b.created_at,
                b.harga_beli,
                b.harga_jual,
                b.kode,
                b.merek,
                COALESCE(s.nama_supplier, '-') AS nama_supplier,
                b.satuan,
                b.stok_minimum,
                b.status,
                b.status_aktif,
                b.deskripsi,
                b.supplier_id
             FROM barang b
             LEFT JOIN supplier s ON s.id = b.supplier_id
             WHERE b.id = ?
             LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public static function getStokRendah() {
        $db = getDB();
        $stmt = $db->query(
            "SELECT
                b.id,
                b.nama_barang AS nama,
                b.nama_barang,
                b.kategori,
                b.stok,
                b.created_at,
                b.harga_beli,
                b.harga_jual,
                b.kode,
                b.merek,
                COALESCE(s.nama_supplier, '-') AS nama_supplier,
                b.satuan,
                b.stok_minimum,
                b.status,
                b.status_aktif,
                b.deskripsi,
                b.supplier_id
             FROM barang b
             LEFT JOIN supplier s ON s.id = b.supplier_id
             WHERE b.status_aktif = 'aktif' AND CAST(COALESCE(b.stok,0) AS SIGNED) <= CAST(COALESCE(b.stok_minimum,0) AS SIGNED)
             ORDER BY CAST(COALESCE(b.stok,0) AS SIGNED) ASC"
        );

        return $stmt->fetchAll();
    }

    public static function generateKodeBarang() {
        $db = getDB();
        $stmt = $db->query("SELECT kode FROM barang WHERE kode LIKE 'BRG-%'");
    
        $maxNumber = 0;
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $kode = trim($row['kode']);
            if (preg_match('/^BRG-(\d+)$/i', $kode, $match)) {
                $number = (int) $match[1];
    
                if ($number > $maxNumber) {
                    $maxNumber = $number;
                }
            }
        }
    
        $nextNumber = $maxNumber + 1;
    
        return 'BRG-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public static function create($data) {
        $db = getDB();
        $kode = self::generateKodeBarang();
        $stok = 0;
    
        $stokMinimum = isset($data['stok_minimum']) ? (int)$data['stok_minimum'] : 0;
        $status = self::statusFromStock($stok, $stokMinimum);
    
        $stmt = $db->prepare(
            "INSERT INTO barang
             (kode, nama_barang, kategori, merek, supplier_id, stok, satuan, stok_minimum, harga_beli, harga_jual, deskripsi, status, status_aktif)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'aktif')"
        );
    
        $nama       = isset($data['nama']) ? trim($data['nama']) : '';
        $kategori   = isset($data['kategori']) ? trim($data['kategori']) : '';
        $merek      = isset($data['merek']) ? trim($data['merek']) : '';
    
        if (!empty($data['supplier_id'])) {
            $supplier_id = $data['supplier_id'];
        } else {
            $supplier_id = null;
        }
    
        $satuan     = isset($data['satuan']) ? trim($data['satuan']) : '';
        $harga_beli = isset($data['harga_beli']) ? $data['harga_beli'] : 0;
        $harga_jual = isset($data['harga_jual']) ? $data['harga_jual'] : 0;
        $deskripsi  = isset($data['deskripsi']) ? trim($data['deskripsi']) : '';
    
        return $stmt->execute([
            $kode,
            $nama,
            $kategori,
            $merek,
            $supplier_id,
            $stok,
            $satuan,
            $stokMinimum,
            $harga_beli,
            $harga_jual,
            $deskripsi,
            $status
        ]);
    }
    public static function update($id, $data) {
        $db = getDB();
        $current = self::findById($id);
        
        if ($current) {
            $stok = (int)$current['stok'];
        } else {
            $stok = 0;
        }
        
        $stokMinimum = isset($data['stok_minimum']) ? $data['stok_minimum'] : 0;
        $status = self::statusFromStock($stok, $stokMinimum);

        $stmt = $db->prepare(
            "UPDATE barang SET
             kode = ?, nama_barang = ?, kategori = ?, merek = ?, supplier_id = ?, 
             satuan = ?, stok_minimum = ?, harga_beli = ?, harga_jual = ?, deskripsi = ?, status = ?
             WHERE id = ?"
        );
        $kode       = isset($data['kode']) ? $data['kode'] : '';
        $nama       = isset($data['nama']) ? $data['nama'] : '';
        $kategori   = isset($data['kategori']) ? $data['kategori'] : '';
        $merek      = isset($data['merek']) ? $data['merek'] : '';
        
        if (!empty($data['supplier_id'])) {
            $supplier_id = $data['supplier_id'];
        } else {
            $supplier_id = null;
        }

        $satuan     = isset($data['satuan']) ? $data['satuan'] : '';
        $harga_beli = isset($data['harga_beli']) ? $data['harga_beli'] : 0;
        $harga_jual = isset($data['harga_jual']) ? $data['harga_jual'] : 0;
        $deskripsi  = isset($data['deskripsi']) ? $data['deskripsi'] : '';
        return $stmt->execute([
            $kode, 
            $nama, 
            $kategori, 
            $merek, 
            $supplier_id, 
            $satuan, 
            $stokMinimum, 
            $harga_beli, 
            $harga_jual, 
            $deskripsi, 
            $status, 
            $id
        ]);
    }

    public static function updateStockStatus($id) {
        $db = getDB();
        $barang = self::findById($id);
        if (!$barang) return false;
        
        $status = self::statusFromStock($barang['stok'], $barang['stok_minimum']);
        $stmt = $db->prepare("UPDATE barang SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public static function delete($id) {
        return self::deactivate($id);
    }

    public static function deactivate($id) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE barang SET status_aktif = 'nonaktif' WHERE id = ?");
        return $stmt->execute([$id]);
    }
  public static function count() {
    $db = getDB();
    return $db->query("SELECT COUNT(*) FROM `barang` WHERE `status_aktif` = 'aktif'")->fetchColumn();
}

    private static function getSupplierName($supplierId) {
        if (empty($supplierId)) {
            return null;
        }

        $db = getDB();
        $stmt = $db->prepare("SELECT nama_supplier FROM supplier WHERE id = ? LIMIT 1");
        $stmt->execute([$supplierId]);
        return $stmt->fetchColumn() ?: null;
    }

    private static function statusFromStock($stok, $stokMinimum) {
        $stok = (int) $stok;
        $stokMinimum = (int) $stokMinimum;

        if ($stok <= 0) {
            return 'Habis';
        }

        if ($stok <= $stokMinimum) {
            return 'Hampir habis';
        } else {
            return 'Tersedia';
        }
    }
}
