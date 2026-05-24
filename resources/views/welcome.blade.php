<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIDU Polinela — Sistem Informasi Data Mahasiswa</title>
    <meta name="description" content="SIDU Polinela - Sistem Informasi Data Mahasiswa Politeknik Negeri Lampung">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #7C3AED;
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
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
            background: rgba(124, 58, 237, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            transition: background 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(91, 33, 182, 0.95);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
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
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
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
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-btn-outline:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.35);
            transform: translateY(-1px);
        }

        .nav-btn-solid {
            background: #fff;
            color: #7C3AED;
        }

        .nav-btn-solid:hover {
            background: #f3f0ff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        /* ======== HERO SECTION ======== */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding: 68px 48px 0;
            background: linear-gradient(160deg, #8B5CF6 0%, #7C3AED 30%, #6D28D9 60%, #7C3AED 100%);
            overflow: hidden;
        }

        /* Subtle animated background shapes */
        .hero::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 700px;
            height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(167, 139, 250, 0.2) 0%, transparent 70%);
            animation: heroFloat 15s ease-in-out infinite;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -8%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(196, 181, 253, 0.12) 0%, transparent 70%);
            animation: heroFloat 12s ease-in-out infinite reverse;
        }

        @keyframes heroFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(20px, -30px) scale(1.05); }
            66% { transform: translate(-15px, 15px) scale(0.98); }
        }

        .hero-container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
            position: relative;
            z-index: 2;
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
            animation: fadeInLeft 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .hero-content h1 {
            font-size: 52px;
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -2px;
            margin-bottom: 20px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .hero-content .subtitle {
            font-size: 17px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 6px;
            letter-spacing: 0.2px;
        }

        .hero-content .institution {
            font-size: 15px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.65);
            margin-bottom: 36px;
        }

        .hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 32px;
            background: #fff;
            color: #7C3AED;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .hero-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px rgba(0, 0, 0, 0.18);
            background: #f5f3ff;
        }

        .hero-cta:active {
            transform: translateY(-1px);
        }

        .hero-cta svg {
            width: 18px;
            height: 18px;
            fill: #7C3AED;
        }

        /* Hero illustration */
        .hero-illustration {
            flex-shrink: 0;
            animation: fadeInRight 1s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards;
            opacity: 0;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .illustration-circle {
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: gentleBounce 6s ease-in-out infinite;
        }

        @keyframes gentleBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .illustration-circle::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.08);
        }

        .illustration-icon {
            width: 160px;
            height: 160px;
        }

        .illustration-icon svg {
            width: 100%;
            height: 100%;
            fill: rgba(255, 255, 255, 0.85);
        }

        /* ======== FEATURES SECTION ======== */
        .features {
            padding: 80px 48px;
            background: #f8f6ff;
            color: #1e1b4b;
        }

        .features-container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .features-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .features-header h2 {
            font-size: 34px;
            font-weight: 800;
            letter-spacing: -1px;
            color: #1e1b4b;
            margin-bottom: 12px;
        }

        .features-header p {
            font-size: 16px;
            color: #6b7280;
            max-width: 500px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .feature-card {
            background: #fff;
            border: 1px solid #e9e5f5;
            border-radius: 20px;
            padding: 32px 28px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #8B5CF6, #A78BFA);
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: left;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(139, 92, 246, 0.1);
            border-color: rgba(139, 92, 246, 0.2);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 18px;
        }

        .feature-icon.purple { background: #f3f0ff; }
        .feature-icon.blue { background: #eff6ff; }
        .feature-icon.green { background: #f0fdf4; }
        .feature-icon.amber { background: #fffbeb; }

        .feature-card h3 {
            font-size: 18px;
            font-weight: 700;
            color: #1e1b4b;
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }

        .feature-card p {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
        }

        /* ======== FOOTER ======== */
        .footer {
            background: #0f0a1a;
            color: rgba(255, 255, 255, 0.6);
            padding: 48px 48px 0;
        }

        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer-brand .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .footer-logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #8B5CF6, #A78BFA);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-logo-icon svg {
            width: 20px;
            height: 20px;
            fill: #fff;
        }

        .footer-logo-text {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .footer-brand p {
            font-size: 14px;
            line-height: 1.7;
            max-width: 320px;
            color: rgba(255, 255, 255, 0.45);
        }

        .footer-col h4 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 18px;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.45);
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
            padding: 24px 0;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.3);
        }

        .footer-bottom a {
            color: rgba(255, 255, 255, 0.3);
            text-decoration: none;
        }

        .footer-bottom a:hover {
            color: #A78BFA;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .footer-social a {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            transition: all 0.2s;
        }

        .footer-social a:hover {
            background: rgba(139, 92, 246, 0.15);
            border-color: rgba(139, 92, 246, 0.3);
            color: #A78BFA;
        }

        /* ======== RESPONSIVE ======== */
        @media (max-width: 1024px) {
            .hero-content h1 {
                font-size: 42px;
            }

            .illustration-circle {
                width: 280px;
                height: 280px;
            }

            .illustration-icon {
                width: 120px;
                height: 120px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0 24px;
            }

            .hero {
                padding: 68px 24px 60px;
            }

            .hero-container {
                flex-direction: column;
                text-align: center;
                gap: 40px;
            }

            .hero-content {
                max-width: 100%;
            }

            .hero-content h1 {
                font-size: 36px;
                letter-spacing: -1px;
            }

            .illustration-circle {
                width: 240px;
                height: 240px;
            }

            .illustration-icon {
                width: 100px;
                height: 100px;
            }

            .features {
                padding: 60px 24px;
            }

            .footer {
                padding: 40px 24px 0;
            }

            .footer-top {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 30px;
            }

            .navbar-brand-text {
                font-size: 17px;
            }
        }
    </style>
</head>
<body>

    <!-- ======== NAVBAR ======== -->
    <nav class="navbar" id="navbar">
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

    <!-- ======== HERO SECTION ======== -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Selamat Datang di SIDU Polinela</h1>
                <p class="subtitle">Sistem Informasi Data Mahasiswa</p>
                <p class="institution">Politeknik Negeri Lampung</p>
                <a href="{{ route('mahasiswa.login') }}" class="hero-cta">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/>
                    </svg>
                    Login ke Sistem
                </a>
            </div>
            <div class="hero-illustration">
                <div class="illustration-circle">
                    <div class="illustration-icon">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <!-- Graduation cap -->
                            <path d="M50 15L10 35l40 20 40-20L50 15z" fill="rgba(255,255,255,0.9)"/>
                            <path d="M25 42v20l25 13 25-13V42L50 55 25 42z" fill="rgba(255,255,255,0.7)"/>
                            <rect x="78" y="35" width="4" height="35" rx="2" fill="rgba(255,255,255,0.6)"/>
                            <circle cx="80" cy="72" r="5" fill="rgba(255,255,255,0.6)"/>
                            <!-- Digital element -->
                            <rect x="35" y="58" width="30" height="20" rx="3" fill="rgba(255,255,255,0.3)" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"/>
                            <path d="M42 65h16M42 69h10" stroke="rgba(255,255,255,0.6)" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    <p>Sistem Informasi Data Mahasiswa — Politeknik Negeri Lampung. Platform digital untuk mengelola proses daftar ulang secara efisien dan transparan.</p>
                </div>
                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="/">Beranda</a></li>
                        <li><a href="#features">Fitur</a></li>
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
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Kontak</h4>
                    <ul>
                        <li><a href="#">📍 Bandar Lampung</a></li>
                        <li><a href="#">📞 (0721) 123-456</a></li>
                        <li><a href="#">✉️ info@polinela.ac.id</a></li>
                        <li><a href="#">🌐 polinela.ac.id</a></li>
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

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Scroll animation for feature cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = `${index * 0.1}s`;
                    entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            observer.observe(card);
        });

        // fadeInUp animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
