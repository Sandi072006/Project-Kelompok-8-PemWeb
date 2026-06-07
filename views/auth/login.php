<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — StockMate</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap');

        :root {
            --font-display: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-body);
            -webkit-font-smoothing: antialiased;
            background: #0d1117;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse at 15% 50%, rgba(244,91,24,0.22) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 20%, rgba(244,91,24,0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 90%, rgba(244,91,24,0.08) 0%, transparent 45%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 52px 52px;
            pointer-events: none;
            z-index: 0;
        }

        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            background: rgb(42, 42, 42);
            border: 1px solid rgba(255,255,255,0.09);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px 44px 36px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.04);
            margin: 24px;
        }

        .login-hero {
            text-align: center;
            margin-bottom: 28px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .login-tagline {
            display: inline-block;
            font-size: 10.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.2px;
            color: #F45B18;
            background: rgba(244,91,24,0.12);
            border: 1px solid rgba(244,91,24,0.25);
            padding: 4px 11px;
            border-radius: 99px;
            margin-bottom: 14px;
        }
        .login-hero h1 {
            font-family: "Playfair Display", serif;
            font-style: italic;
            font-size: 30px;
            font-weight: 600;
            color: #fff;
            letter-spacing: -1.2px;
            line-height: 1.15;
            margin-bottom: 10px;
        }
        .login-hero h1 span { color: #F45B18; }
        .login-hero p { font-size: 13px; color: #6b7280; line-height: 1.6; }

        .form-header { margin-bottom: 20px; }
        .form-header h2 { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            font-size: 20px; 
            font-weight: 800; 
            color: #fff; 
            letter-spacing: -0.4px; 
        }

        .alert-error {
            margin-bottom: 16px;
            padding: 10px 14px;
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            border-radius: 8px;
            font-size: 12.5px;
            color: #fca5a5;
        }

        .field { margin-bottom: 16px; }
        .field label { display: block; font-family: var(--font-display); font-size: 11px; font-weight: 700; color: #9ca3af; letter-spacing: 0.4px; text-transform: uppercase; margin-bottom: 7px; }
        .field input {
            width: 100%; padding: 11px 14px 11px 40px;
            border: 1.5px solid rgba(255,255,255,0.1); border-radius: 9px;
            font-family: var(--font-body); font-size: 14px;
            color: #fff; background: rgba(255,255,255,0.06);
            outline: none; box-sizing: border-box;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field input::placeholder { color: rgba(255,255,255,0.25); }
        .field input:focus { border-color: #F45B18; box-shadow: 0 0 0 3px rgba(244,91,24,0.18); background: rgba(255,255,255,0.08); }

        .input-wrap { position: relative; }
        .input-wrap svg {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            width: 16px; height: 16px;
            stroke: rgba(255,255,255,0.3); fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
            pointer-events: none; transition: stroke 0.15s;
        }
        .field input:focus ~ svg { stroke: #F45B18; }

        .btn-login {
            width: 100%; padding: 13px;
            background: #F45B18; color: #fff; border: none; border-radius: 9px;
            font-family: var(--font-display); font-size: 14px; font-weight: 700;
            cursor: pointer; margin-top: 6px;
            transition: opacity 0.15s, transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 4px 16px rgba(244,91,24,0.4);
        }
        .btn-login:hover { opacity: 0.92; transform: translateY(-1px); box-shadow: 0 6px 22px rgba(244,91,24,0.45); }
        .btn-login:active { transform: translateY(0); }

        .form-footer { margin-top: 20px; text-align: center; font-size: 11.5px; color: rgba(255,255,255,0.2); }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-hero">
            <span class="login-tagline">Smart Supplier System</span>
            <h1>STOCKMATE</h1>
            <p>Platform manajemen inventaris supermarket yang cerdas. Pantau stok, supplier, dan pemasokan dalam satu dashboard terpadu.</p>
        </div>

        <div class="form-header">
            <h2>Login</h2>
        </div>

        <?php if (!empty($_GET['error'])): ?>
            <div class="alert-error">
                <?php echo ($_GET['error'] == 1) ? 'Username dan password tidak boleh kosong.' : 'Username atau password salah.'; ?>
            </div>
        <?php endif; ?>

        <form action="<?= defined('BASE_URL') ? BASE_URL : '' ?>/login/proses" method="post">
            <div class="field">
                <label>Username</label>
                <div class="input-wrap">
                    <input type="text" name="username" placeholder="Masukkan username" autocomplete="username" required>
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
            </div>
            <div class="field">
                <label>Password</label>
                <div class="input-wrap">
                    <input type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
                    <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="form-footer">StockMate &copy; 2026 — Kelompok 8</div>
    </div>

</body>
</html>