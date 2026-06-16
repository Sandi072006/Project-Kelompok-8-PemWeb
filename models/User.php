<?php
class User {

    public static function cekKredensial($username, $password) {
        
        $fixedUsers = [
            'admin' => [
                'id'       => 1,
                'username' => 'admin',
                'nama'     => 'Administrator',
                'password' => 'admin123',
                'role'     => 'admin',
            ],
            'petugas' => [
                'id'       => 2,
                'username' => 'petugas',
                'nama'     => 'Petugas',
                'password' => 'petugas123',
                'role'     => 'petugas',
            ],
        ];

        if (isset($fixedUsers[$username]) && $password === $fixedUsers[$username]['password']) {
            return $fixedUsers[$username];
        }

        $db = getDB();
        
        $stmt = $db->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        if ($password === $user['password']) {
            return $user;
        }

        return false;
    }

    public static function findById($id) {
        $db = getDB();
        
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
