<?php

class AuthController {

    public static function cekLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit; 
        }
    }

    public static function cekAdmin() {
        self::cekLogin();
        
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/dashboard');
            exit; 
        }
    }

    public function index() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] === 'admin') {
                header('Location: ' . BASE_URL . '/admin/dashboard');
            } else {
                header('Location: ' . BASE_URL . '/dashboard');
            }
            exit;
        }
        require_once ROOT . '/views/auth/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        if (isset($_POST['username'])) {
            $username = trim($_POST['username']);
        } else {
            $username = '';
        }

        if (isset($_POST['password'])) {
            $password = trim($_POST['password']);
        } else {
            $password = '';
        }

        if (empty($username) || empty($password)) {
            header('Location: ' . BASE_URL . '/login?error=1');
            exit;
        }

        $user = User::cekKredensial($username, $password);

        if ($user) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['user']     = $user;
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama']     = $user['nama'];
            $_SESSION['role']     = $user['role'];

            if ($user['role'] === 'admin') {
                header('Location: ' . BASE_URL . '/admin/dashboard');
            } else {
                header('Location: ' . BASE_URL . '/dashboard');
            }
            exit;
        } else {
            header('Location: ' . BASE_URL . '/login?error=2');
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
