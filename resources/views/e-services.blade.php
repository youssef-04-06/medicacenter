<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>E-Services</title>

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
            --bg-main: #f5f8fa;
            --card-bg: #ffffff;
            --text-dark: #0d1b2a;
            --accent: #007bff;
            --radius: 14px;
        }

        body {
            margin: 0;
            font-family: "Poppins", Arial, sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
        }

      

        /* PAGE CONTENT */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 40px;
            color: var(--accent);
        }

        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 40px;
            text-align: center;
            box-shadow: 0 6px 12px blue;
            max-width: 700px;
            width: 70%;
            margin: 30px auto;
        }

        .card img.logo {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
            border-radius: 12px;
        }

        .store-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 20px;
        }

        .btn-store {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: var(--accent);
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 12px 14px;
            border-radius: var(--radius);
            transition: 0.2s;
        }

        .btn-store:hover {
            background: #0056b3;
            transform: scale(1.03);
        }

        .btn-store img {
            width: 22px;
            height: 22px;
        }

        
    </style>
</head>

<body>

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


    <!-- PAGE CONTENT -->
    <div class="container">
        <h1>E-Services</h1>

        <div class="card">
            <img class="logo" src="{{ asset('images/download (1).jpg') }}" alt="Sehhati App">

            <div class="store-buttons">
                <a href="#" class="btn-store">
                    <img src="{{ asset('images/apple-logo.png') }}" alt="App Store">
                    <span>Download on App Store</span>
                </a>

                <a href="#" class="btn-store">
                    <img src="{{ asset('images/download(1).jpg') }}">
                    <span>Get it on Play Store</span>
                </a>
            </div>
        </div>
    </div>


    <!-- FOOTER -->
    
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
        document.querySelectorAll('.btn-store').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                alert('Redirecting to the store...');
            });
        });
    </script>

</body>
</html>