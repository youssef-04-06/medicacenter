<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Healthcare Services — Accordion</title>

    <!-- Optional: Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        
        /* ================= HEADER ================= */

        header {
            background-color: #e3f2fd;
            min-height: 68px;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #90caf9;
            font-family: "Poppins", sans-serif;
        }

        .logo h1 {
            color: #0077b6;
            margin: 0;
            font-size: 24px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        .nav-links li a {
            text-decoration: none;
            color: #0077b6;
            font-weight: 600;
            font-size: 16px;
        }

        .auth-buttons {
            display: flex;
            gap: 15px;
        }

        .global-site-search {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .global-site-search input {
            width: 190px;
            padding: 8px 10px;
            border: 1px solid #b9d9eb;
            border-radius: 6px;
        }

        .global-site-search button {
            padding: 8px 11px;
            border: 0;
            border-radius: 6px;
            background: #0077b6;
            color: #fff;
            cursor: pointer;
        }

        .auth-buttons a {
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 15px;
        }

        .login-btn {
            color: #0077b6;
        }

        .signup-btn {
            background-color: #0077b6;
            color: white;
        }

        /* ================= FOOTER ================= */

        footer {
            background: linear-gradient(to right, #f9fbfd, #eef6fb);
            color: #333;
            padding: 60px 20px 20px;
            font-family: "Poppins", sans-serif;
            border-top: 3px solid #cce0f5;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        footer h3, footer h4 {
            font-weight: bold;
            color: #00509e;
            margin-bottom: 15px;
        }

        .footer-about p {
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links ul li {
            margin-bottom: 10px;
        }

        .footer-links ul li a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .footer-links ul li a:hover {
            color: #0099ff;
            padding-left: 5px;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 30px;
            padding: 20px 0;
            font-size: 0.95rem;
            font-weight: 800;
            background-color: cornflowerblue;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
    

        :root {
            --bg: #ffffff;
            --primary: #1e66b3;
            --card: #39A9E6;
            --card-dark: #2b9bd6;
            --muted: #6b6b6b;
            --max-width: 820px;
        }

        * { box-sizing: border-box }

        body {
            margin: 0;
            background: var(--bg);
            font-family: 'Poppins', system-ui, sans-serif;
            color: #222;
        }


        /* ===========================
             PAGE CONTENT
        ============================*/
        .page {
            max-width: var(--max-width);
            margin: 24px auto;
            padding: 20px;
        }

        header.page-head {
            text-align: center;
            padding-top: 10px;
        }

        .kicker {
            color: #6bb0db;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 6px;
        }

        h1 {
            margin: 0 0 14px;
            font-size: 30px;
            color: var(--primary);
            font-weight: 700;
        }

        p.lead {
            max-width: 720px;
            margin: 0 auto 26px auto;
            color: var(--muted);
            line-height: 1.5;
            font-size: 15px;
            padding: 0 8px;
        }

        /* ===========================
             ACCORDION
        ============================*/
        .accordion {
            display: flex;
            flex-direction: column;
            gap: 18px;
            padding: 6px;
        }

        .card {
            background: var(--card);
            color: white;
            border-radius: 18px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(31,95,145,0.08);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .card-inner {
            display: flex;
            gap: 14px;
            align-items: center;
            flex: 1;
        }

        .icon {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            background: rgba(255,255,255,0.12);
            border-radius: 10px;
        }

        .label { font-size: 18px; font-weight: 600; }

        .chev {
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            opacity: 0.95;
            transition: transform .25s;
        }

        .panel {
            overflow: hidden;
            max-height: 0;
            transition: max-height .36s, padding .25s;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            margin-top: 8px;
            padding: 0 12px;
        }

        .panel-content {
            padding: 12px 6px 16px;
            color: #f7fbff;
            font-size: 14px;
        }

        .card.active .chev { transform: rotate(180deg); }
        .card.active + .panel { padding: 10px 12px 16px; }

        @media (max-width:520px) {
            h1 { font-size: 26px; }
            .label { font-size: 16px; }
            .card { padding: 12px; }
            .icon { width: 40px; height: 40px; }
        }
    </style>
</head>

<body>

    <!-- ===========================
           HEADER
    ============================-->
  
    < <header>
        <div class="logo">
            <h1>HospiBridge</h1>
        </div>

        <nav>
            <ul class="nav-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/about') }}">About</a></li>
                <li><a href="{{ url('/awareness') }}">Awareness</a></li>
                <li><a href="{{ url('/services') }}">Services</a></li>
                <li><a href="{{ url('/contactz') }}">Contactz</a></li>
            </ul>
        </nav>

        <div class="auth-buttons">
            <form class="global-site-search" role="search" method="GET" action="{{ route('services') }}">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search services..." aria-label="Search services">
                <button type="submit" aria-label="Search services"><i class="fas fa-search"></i></button>
            </form>
            <a href="/login" class="login-btn">Login</a>
            <a href="/register" class="signup-btn">Sign Up</a>
        </div>
    </header>


    <!-- ===========================
           MAIN PAGE CONTENT
    ============================-->
    <div class="page" role="main">
        <header class="page-head">
            <div class="kicker">Healthcare Services</div>
            <h1>Healthcare Services Provided in the Clusters</h1>
            <p class="lead">
                The health clusters offer a comprehensive range of healthcare services through an integrated network of central and general hospitals, as well as specialized centers.
            </p>
        </header>

        <section class="accordion">


            <!-- CARD 1 -->
            <button class="card" data-target="p1">
                <div class="card-inner">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M3 11.5L12 4l9 7.5" stroke="#fff" stroke-width="1.6" />
                            <path d="M5 21V11h14v10" stroke="#fff" stroke-width="1.6" />
                        </svg>
                    </span>
                    <span class="label">Home Care</span>
                </div>
                <span class="chev">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9l6 6 6-6" stroke="#fff" stroke-width="2" />
                    </svg>
                </span>
            </button>
            <div id="p1" class="panel">
                <div class="panel-content">
                    Home-based medical services including nursing visits, medication management, follow-up, and palliative care.
                </div>
            </div>


            <!-- CARD 2 -->
            <button class="card" data-target="p2">
                <div class="card-inner">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M12 12a3 3 0 100-6 3 3 0 000 6z" stroke="#fff" stroke-width="1.5"/>
                            <path d="M4 20v-1a4 4 0 014-4h8a4 4 0 014 4v1" stroke="#fff" stroke-width="1.5"/>
                        </svg>
                    </span>
                    <span class="label">Primary Health Care</span>
                </div>
                <span class="chev">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9l6 6 6-6" stroke="#fff" stroke-width="2" />
                    </svg>
                </span>
            </button>
            <div id="p2" class="panel">
                <div class="panel-content">
                    Preventive and curative services including immunizations, routine consultations, maternal and child health.
                </div>
            </div>


            <!-- CARD 3 -->
            <button class="card" data-target="p3">
                <div class="card-inner">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M3 12h18v7a1 1 0 01-1 1H4a1 1 0 01-1-1v-7z" stroke="#fff" stroke-width="1.5" />
                            <path d="M7 12V9a3 3 0 016 0v3" stroke="#fff" stroke-width="1.5" />
                        </svg>
                    </span>
                    <span class="label">Specialty Care</span>
                </div>
                <span class="chev">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9l6 6 6-6" stroke="#fff" stroke-width="2" />
                    </svg>
                </span>
            </button>
            <div id="p3" class="panel">
                <div class="panel-content">
                    Specialized medical services such as surgery, emergency care, ICU support, and medical subspecialties.
                </div>
            </div>


            <!-- CARD 4 -->
            <button class="card" data-target="p4">
                <div class="card-inner">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M3 11a9 9 0 0118 0v5a3 3 0 01-3 3H6a3 3 0 01-3-3v-5z" stroke="#fff" stroke-width="1.5"/>
                            <path d="M12 14v2" stroke="#fff" stroke-width="1.6"/>
                        </svg>
                    </span>
                    <span class="label">Virtual Care</span>
                </div>
                <span class="chev">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9l6 6 6-6" stroke="#fff" stroke-width="2" />
                    </svg>
                </span>
            </button>
            <div id="p4" class="panel">
                <div class="panel-content">
                    Telemedicine consultations, online follow-ups, counselling, and remote triage.
                </div>
            </div>

        </section>
    </div>



    <!-- ===========================
           FOOTER
    ============================-->
   <footer class="site-footer">
        <div class="container footer-container">

            <div class="footer-about">
                <h3>HospiBridge</h3>
                <p>Your trusted healthcare partner, providing modern medical services with care and excellence.</p>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ url('/index') }}">Home</a></li>
                    <li><a href="{{ url('/services') }}">Services</a></li>
                    <li><a href="{{ url('/appointments') }}">Appointments</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            © 2025 HospiBridge — All Rights Reserved.
        </div>
    </footer>



    <script>
    // Accordion behavior
    document.querySelectorAll('.card').forEach(card => {
        const id = card.dataset.target;
        const panel = document.getElementById(id);

        card.addEventListener('click', () => {
            const active = card.classList.contains('active');

            document.querySelectorAll('.card').forEach(c => {
                c.classList.remove('active');
                const p = document.getElementById(c.dataset.target);
                p.style.maxHeight = null;
            });

            if (!active) {
                card.classList.add('active');
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    });
    </script>

</body>
</html>