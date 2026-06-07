<?php
// ─── Auth Controller ────────────────────────────────────────────
class AuthController {

    // ── Cek apakah sudah login (dipanggil di controller lain) ──
    public static function cekLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    // ── Cek apakah role-nya admin ──
    public static function cekAdmin() {
        self::cekLogin();
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
    }

    // ── Tampilkan halaman login ──
    public function index() {
        // Kalau sudah login, redirect langsung
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

    // ── Proses form login ──
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            header('Location: ' . BASE_URL . '/login?error=1');
            exit;
        }

        $user = User::cekKredensial($username, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user']    = $user;
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

    // ── Logout ──
    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}