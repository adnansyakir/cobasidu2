<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIDU - Sistem Daftar Ulang')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #0f0a1a;
            position: relative;
        }

        /* ======== NAVBAR ======== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 0 48px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(15, 10, 26, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
        }

        .navbar-logo {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #8B5CF6, #A78BFA);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-logo svg {
            width: 20px;
            height: 20px;
            fill: #fff;
        }

        .navbar-brand-text {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-btn {
            padding: 9px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
            border: none;
        }

        .nav-btn-outline {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .nav-btn-outline:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .nav-btn-solid {
            background: linear-gradient(135deg, #8B5CF6, #7C3AED);
            color: #fff;
        }

        .nav-btn-solid:hover {
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.35);
            transform: translateY(-1px);
        }

        /* ======== MAIN LOGIN AREA ======== */
        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 88px 20px 40px;
            position: relative;
        }

        /* Animated gradient background */
        .bg-gradient {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: 
                radial-gradient(ellipse at 20% 50%, rgba(139, 92, 246, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(168, 85, 247, 0.25) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 80%, rgba(196, 181, 253, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 70% 60%, rgba(124, 58, 237, 0.2) 0%, transparent 50%);
            animation: bgShift 12s ease-in-out infinite alternate;
        }

        @keyframes bgShift {
            0% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.1) rotate(2deg); }
            100% { transform: scale(1) rotate(-1deg); }
        }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            animation: float 8s ease-in-out infinite;
            z-index: 0;
        }

        .orb-1 {
            width: 300px;
            height: 300px;
            background: rgba(139, 92, 246, 0.5);
            top: -100px;
            left: -100px;
            animation-delay: 0s;
            animation-duration: 10s;
        }

        .orb-2 {
            width: 250px;
            height: 250px;
            background: rgba(168, 85, 247, 0.4);
            bottom: -80px;
            right: -80px;
            animation-delay: -3s;
            animation-duration: 12s;
        }

        .orb-3 {
            width: 200px;
            height: 200px;
            background: rgba(196, 181, 253, 0.3);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -5s;
            animation-duration: 9s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            25% { transform: translateY(-30px) translateX(15px); }
            50% { transform: translateY(10px) translateX(-10px); }
            75% { transform: translateY(-15px) translateX(20px); }
        }

        /* Grid pattern overlay */
        .grid-pattern {
            position: fixed;
            inset: 0;
            z-index: 1;
            background-image: 
                linear-gradient(rgba(139, 92, 246, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(139, 92, 246, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        /* Login card */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 20px;
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 
                0 32px 64px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.05) inset,
                0 -4px 24px rgba(139, 92, 246, 0.1) inset;
        }

        .login-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .login-logo {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, #8B5CF6, #A78BFA, #C4B5FD);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            box-shadow: 0 8px 24px rgba(139, 92, 246, 0.4);
            animation: logoPulse 3s ease-in-out infinite;
        }

        @keyframes logoPulse {
            0%, 100% { box-shadow: 0 8px 24px rgba(139, 92, 246, 0.4); }
            50% { box-shadow: 0 8px 40px rgba(139, 92, 246, 0.6); }
        }

        .login-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .login-header p {
            font-size: 14px;
            color: rgba(196, 181, 253, 0.7);
            font-weight: 400;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: rgba(196, 181, 253, 0.8);
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            color: #fff;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-group input::placeholder {
            color: rgba(196, 181, 253, 0.35);
        }

        .form-group input:focus {
            border-color: rgba(139, 92, 246, 0.6);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            appearance: none;
            width: 18px;
            height: 18px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .remember-me input[type="checkbox"]:checked {
            background: #8B5CF6;
            border-color: #8B5CF6;
        }

        .remember-me input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
        }

        .remember-me span {
            font-size: 13px;
            color: rgba(196, 181, 253, 0.6);
        }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #8B5CF6, #7C3AED);
            border: none;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.3px;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #A78BFA, #8B5CF6);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(139, 92, 246, 0.4);
        }

        .btn-login:hover::before {
            opacity: 1;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login span {
            position: relative;
            z-index: 1;
        }

        /* Error messages */
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            animation: shakeX 0.5s ease;
        }

        .alert-error ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .alert-error li {
            font-size: 13px;
            color: #fca5a5;
            line-height: 1.5;
        }

        @keyframes shakeX {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-8px); }
            40% { transform: translateX(8px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        /* Footer link */
        .login-footer {
            text-align: center;
            margin-top: 24px;
        }

        .login-footer a {
            font-size: 13px;
            color: rgba(196, 181, 253, 0.6);
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-footer a:hover {
            color: #A78BFA;
        }

        /* ======== FOOTER ======== */
        .footer {
            position: relative;
            z-index: 10;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.5);
            padding: 40px 48px 0;
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            padding-bottom: 32px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .footer-brand .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .footer-logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: linear-gradient(135deg, #8B5CF6, #A78BFA);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-logo-icon svg {
            width: 18px;
            height: 18px;
            fill: #fff;
        }

        .footer-logo-text {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .footer-brand p {
            font-size: 13px;
            line-height: 1.7;
            max-width: 300px;
            color: rgba(255, 255, 255, 0.35);
        }

        .footer-col h4 {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 16px;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 9px;
        }

        .footer-col ul li a {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-col ul li a:hover {
            color: #A78BFA;
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 0;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.25);
        }

        .footer-social {
            display: flex;
            gap: 10px;
        }

        .footer-social a {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.35);
            text-decoration: none;
            transition: all 0.2s;
        }

        .footer-social a:hover {
            background: rgba(139, 92, 246, 0.15);
            border-color: rgba(139, 92, 246, 0.3);
            color: #A78BFA;
        }

        /* ======== RESPONSIVE ======== */
        @media (max-width: 768px) {
            .navbar {
                padding: 0 20px;
            }

            .footer {
                padding: 32px 20px 0;
            }

            .footer-top {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Background effects -->
    <div class="bg-gradient"></div>
    <div class="grid-pattern"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- ======== NAVBAR ======== -->
    <nav class="navbar">
        <a href="/" class="navbar-brand">
            <div class="navbar-logo">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                </svg>
            </div>
            <span class="navbar-brand-text">SIDU</span>
        </a>
        <div class="navbar-menu">
            <a href="/" class="nav-btn nav-btn-outline">Beranda</a>
            <a href="{{ route('mahasiswa.login') }}" class="nav-btn nav-btn-solid">Login</a>
        </div>
    </nav>

    <!-- ======== MAIN CONTENT ======== -->
    <div class="login-wrapper">
        @yield('content')
    </div>

    <!-- ======== FOOTER ======== -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <div class="footer-logo-icon">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                            </svg>
                        </div>
                        <span class="footer-logo-text">SIDU</span>
                    </div>
                    <p>Sistem Informasi Data Mahasiswa — Politeknik Negeri Lampung. Platform digital untuk mengelola proses daftar ulang.</p>
                </div>
                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="/">Beranda</a></li>
                        <li><a href="{{ route('mahasiswa.login') }}">Login Mahasiswa</a></li>
                        <li><a href="{{ route('admin.login') }}">Login Admin</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Bantuan</h4>
                    <ul>
                        <li><a href="#">Panduan</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Kontak</h4>
                    <ul>
                        <li><a href="#">📍 Bandar Lampung</a></li>
                        <li><a href="#">📞 (0721) 123-456</a></li>
                        <li><a href="#">✉️ info@polinela.ac.id</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} SIDU Polinela. All rights reserved.</span>
                <!-- <div class="footer-social">
                    <a href="#" title="Instagram">📷</a>
                    <a href="#" title="Facebook">📘</a>
                    <a href="#" title="YouTube">🎬</a>
                </div> -->
            </div>
        </div>
    </footer>
</body>
</html>
