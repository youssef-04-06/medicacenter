<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HospiBridge AI - Register</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>

:root{
    --primary:#00d4ff;
    --secondary:#2563eb;
    --dark:#020617;
    --card:#0f172a;
    --text:#e2e8f0;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}
.navbar-custom {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow: 0 8px 32px rgba(0, 119, 182, 0.1);
    min-height: 68px;
    padding: 10px 0;
    border-bottom: 1px solid rgba(0, 119, 182, 0.08);
}

.navbar-title {
    font-size: 20px;
    color: #0077b6;
    font-family: 'Poppins', sans-serif;
    letter-spacing: -0.5px;
}

.nav-link-custom {
    color: #00b4d8 !important;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    padding-bottom: 5px;
}

.nav-link-custom::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #00b4d8, #0077b6);
    transition: width 0.3s ease;
}

.nav-link-custom:hover::after {
    width: 100%;
}

.nav-link-custom:hover {
    color: #0077b6 !important;
    transform: translateY(-2px);
}

.nav-link-login {
    color: #0077b6 !important;
    font-weight: 600;
    transition: all 0.3s ease;
    padding: 8px 12px;
}

.nav-link-login:hover {
    color: #005f8d !important;
}

.btn-register {
    background: linear-gradient(135deg, #00b4d8 0%, #0077b6 100%);
    color: #ffffff !important;
    border: none;
    padding: 10px 24px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 119, 182, 0.25);
}

.btn-register:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 119, 182, 0.4);
    background: linear-gradient(135deg, #0077b6 0%, #004e7c 100%);
    color: #ffffff !important;
}

.search-input {
    border: 2px solid #e0e0e0;
    border-radius: 20px;
    padding: 8px 16px;
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: #00b4d8;
    box-shadow: 0 0 10px rgba(0, 180, 216, 0.2);
}

.btn-search {
    background-color: #00b4d8;
    color: white;
    border: none;
    border-radius: 20px;
    padding: 8px 16px;
    margin-left: -35px;
    transition: all 0.3s ease;
}

.btn-search:hover {
    background-color: #0077b6;
}

.social-icons-nav {
    gap: 12px;
}

.social-link {
    color: #0077b6;
    transition: all 0.3s ease;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: rgba(0, 119, 182, 0.05);
}

.social-link:hover {
    background-color: #00b4d8;
    color: white;
    transform: scale(1.1);
}

html {
    scroll-behavior: smooth;
}

body{
    min-height:100vh;
    background:
    radial-gradient(circle at 10% 20%, rgba(0,212,255,.18), transparent 30%),
    radial-gradient(circle at 90% 80%, rgba(37,99,235,.20), transparent 35%),
    linear-gradient(135deg,#020617,#0f172a,#111827);
    overflow-x:hidden;
    position:relative;
}

body::before{
    content:'';
    position:absolute;
    width:450px;
    height:450px;
    background:#00d4ff;
    filter:blur(180px);
    opacity:.12;
    top:-150px;
    left:-150px;
}

body::after{
    content:'';
    position:absolute;
    width:450px;
    height:450px;
    background:#2563eb;
    filter:blur(180px);
    opacity:.12;
    bottom:-150px;
    right:-150px;
}

.hero{
    min-height:100vh;
    display:flex;
    align-items:center;
    position:relative;
    z-index:1;
}

.badge-ai{
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.12);
    backdrop-filter:blur(15px);
    color:white;
    padding:12px 22px;
    border-radius:50px;
    display:inline-flex;
    gap:10px;
    align-items:center;
    margin-bottom:25px;
}

.hero-title{
    font-size:4.2rem;
    font-weight:900;
    line-height:1.1;
    color:white;
}

.hero-title span{
    background:linear-gradient(90deg,#00d4ff,#2563eb);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.hero-text{
    color:#cbd5e1;
    font-size:1.1rem;
    line-height:1.9;
    margin-top:20px;
    margin-bottom:35px;
}

.feature-card{
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.08);
    backdrop-filter:blur(20px);
    border-radius:20px;
    padding:22px;
    transition:.4s;
    height:100%;
}

.feature-card:hover{
    transform:translateY(-8px);
    box-shadow:0 20px 40px rgba(0,212,255,.15);
}

.feature-card i{
    color:#00d4ff;
    font-size:2rem;
    margin-bottom:15px;
}

.feature-card h5{
    color:white;
}

.feature-card p{
    color:#cbd5e1;
    margin-bottom:0;
}

.register-card{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
    backdrop-filter:blur(30px);
    border-radius:30px;
    padding:40px;
    box-shadow:0 20px 60px rgba(0,0,0,.35);
}

.register-title{
    color:white;
    font-weight:800;
    text-align:center;
    margin-bottom:30px;
}

.form-label{
    color:white;
    font-weight:500;
}

.form-control{
    background:rgba(255,255,255,.07);
    border:1px solid rgba(255,255,255,.1);
    color:white;
    padding:14px;
    border-radius:14px;
}

.form-control:focus{
    background:rgba(255,255,255,.10);
    color:white;
    border-color:#00d4ff;
    box-shadow:0 0 20px rgba(0,212,255,.25);
}

.form-control::placeholder{
    color:#94a3b8;
}

.btn-register{
    background:linear-gradient(135deg,#00d4ff,#2563eb);
    border:none;
    color:white;
    font-weight:700;
    padding:14px;
    border-radius:14px;
    transition:.4s;
}

.btn-register:hover{
    color:white;
    transform:translateY(-3px);
    box-shadow:0 15px 35px rgba(0,212,255,.25);
}

.signin-link{
    color:#cbd5e1;
}

.signin-link a{
    color:#00d4ff;
    text-decoration:none;
    font-weight:600;
}

.ai-circle{
    position:absolute;
    border-radius:50%;
    border:1px solid rgba(255,255,255,.08);
    animation:rotate 20s linear infinite;
}

.circle-1{
    width:300px;
    height:300px;
    top:10%;
    right:5%;
}

.circle-2{
    width:450px;
    height:450px;
    bottom:-100px;
    left:-100px;
}

@keyframes rotate{
    from{transform:rotate(0deg);}
    to{transform:rotate(360deg);}
}

@media(max-width:991px){

    .hero{
        padding:50px 0;
    }

    .hero-title{
        font-size:2.8rem;
    }

    .register-card{
        margin-top:40px;
    }
}
.footer {
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

.footer h3,
.footer h4 {
    margin-bottom: 15px;
    font-weight: bold;
    color: #00509e;
}

.footer-about p {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #444;
}

.footer-links ul {
    list-style: none;
    padding: 0;
}

    .footer-links ul li {
        margin-bottom: 10px;
    }

        .footer-links ul li a {
            text-decoration: none;
            color: #0066cc;
            font-weight: 500;
            transition: color 0.3s, padding-left 0.3s;
        }

            .footer-links ul li a:hover {
                color: #0099ff;
                padding-left: 5px;
            }

.footer-contact p {
    margin-bottom: 8px;
    font-size: 0.95rem;
    color: #444;
}

.footer-social .social-icons {
    display: flex;
    gap: 12px;
}

.footer-social a {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #0099ff;
    color: #fff;
    font-size: 1.1rem;
    transition: transform 0.3s, background 0.3s, box-shadow 0.3s;
}

    .footer-social a:hover {
        background: #0077cc;
        box-shadow: 0 4px 10px rgba(0, 153, 255, 0.3);
        transform: translateY(-4px);
    }

/* Footer Bottom with Gradient Text */
.footer-bottom {
    text-align: center;
    margin-top: 30px;
    padding: 20px 0;
    font-size: 0.95rem;
    font-weight: 800;
    /* */
    color: #ffffff;
    /*  */
    background-color: cornflowerblue;
    /* Optional white shadow */
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .footer-container {
        grid-template-columns: 1fr 1fr; /*  */
    }
}

@media (max-width: 480px) {
    .footer-container {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .footer-social {
        justify-content: center;
    }
}
/* ===== Header Styles ===== */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
    background-color: #f9fbfd;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    font-family: 'Poppins', sans-serif;
}

/* Logo */
.logo {
    display: flex;
    align-items: center;
    gap: 12px;
}

    .logo svg {
        width: 50px;
        height: 50px;
    }

    .logo span {
        font-size: 28px;
        font-weight: 700;
        color: #0077b6;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

/* Navigation */
nav ul.nav-links {
    list-style: none;
    display: flex;
    gap: 25px;
    margin: 0;
    padding: 0;
}

    nav ul.nav-links li a {
        text-decoration: none;
        color: #0077b6;
        font-weight: 500;
        transition: color 0.3s, transform 0.2s;
    }

        nav ul.nav-links li a:hover {
            color: #00b4d8;
            transform: translateY(-2px);
        }

/* Responsive */
@media (max-width: 768px) {
    header {
        flex-direction: column;
        align-items: flex-start;
    }

    nav ul.nav-links {
        flex-direction: column;
        gap: 15px;
        margin-top: 15px;
    }
}


/*css for contact page */

.contact-hero {
    position: relative;
    background: url('projimages/happydoctors.jpg') no-repeat center center;
    background-size: cover;
    min-height: 500px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

    .contact-hero .overlay {
        background: rgba(255, 255, 255, 0.85);
        padding: 40px;
        border-radius: 15px;
        max-width: 500px;
        width: 100%;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .contact-hero h2 {
        font-size: 2rem;
        color: #0077b6;
        margin-bottom: 20px;
    }

    .contact-hero .contact-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .contact-hero input,
    .contact-hero textarea {
        padding: 12px 15px;
        border-radius: 10px;
        border: 1px solid #ddd;
        font-size: 1rem;
        outline: none;
        transition: all 0.3s ease;
    }

        .contact-hero input:focus,
        .contact-hero textarea:focus {
            border-color: #0077b6;
            box-shadow: 0 0 8px rgba(0, 119, 182, 0.2);
        }

    .contact-hero textarea {
        resize: none;
        height: 120px;
    }

    .contact-hero button {
        background: linear-gradient(90deg, #0077b6, #00b4d8);
        color: #fff;
        border: none;
        padding: 14px;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 10px;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
    }

        .contact-hero button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 119, 182, 0.2);
        }

</style>
</head>

<body>
    <section>   <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <svg width="36" height="36" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" class="me-2">
                    <path d="M32 4 L12 16 V36 C12 50 32 60 32 60 C32 60 52 50 52 36 V16 Z" fill="#00b4d8" />
                    <path d="M32 20 v16 M24 28 h16" stroke="#ffffff" stroke-width="4" stroke-linecap="round" />
                </svg>
                <span class="fw-bold navbar-title">HospiBridge</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-5 mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active" href="{{ url('/') }}"><i class="fas fa-home me-2"></i>Home</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link nav-link-custom" href="{{ url('/services') }}"><i class="fas fa-hospital me-2"></i>Services</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link nav-link-custom" href="{{ url('/contactz') }}"><i class="fas fa-envelope me-2"></i>Contactz</a>
                    </li>
                </ul>
                <div class="ms-auto d-flex align-items-center gap-3">
                    <form class="d-flex" role="search">
                        <input class="form-control search-input" type="search" placeholder="Search services..." aria-label="Search">
                        <button class="btn btn-search" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                    <a class="nav-link nav-link-login" href="{{ url('/login') }}"><i class="fas fa-sign-in-alt me-2"></i>Login</a>
                    <a class="btn btn-register" href="{{ url('/register') }}"><i class="fas fa-user-plus me-2"></i>Register</a>
                    <div class="d-flex ms-3 social-icons-nav">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </nav></section> 

<div class="ai-circle circle-1"></div>
<div class="ai-circle circle-2"></div>

<section class="hero">
<div class="container">

<div class="row align-items-center">

<div class="col-lg-7 mb-5 mb-lg-0">

<div class="badge-ai">
<i class="fas fa-robot"></i>
AI Powered Healthcare Platform
</div>

<h1 class="hero-title">
The Future of <span>Smart Healthcare</span>
</h1>

<p class="hero-text">
Join HospiBridge and experience AI-powered healthcare services,
intelligent appointment scheduling, digital medical records,
predictive health insights, and secure patient management
through one advanced platform.
</p>

<div class="row g-4">

<div class="col-md-4">
<div class="feature-card">
<i class="fas fa-brain"></i>
<h5>AI Diagnosis</h5>
<p>Smart symptom analysis and recommendations.</p>
</div>
</div>

<div class="col-md-4">
<div class="feature-card">
<i class="fas fa-calendar-check"></i>
<h5>Smart Booking</h5>
<p>Schedule appointments instantly.</p>
</div>
</div>

<div class="col-md-4">
<div class="feature-card">
<i class="fas fa-file-medical"></i>
<h5>E-Records</h5>
<p>Secure cloud-based patient records.</p>
</div>
</div>

</div>

</div>

<div class="col-lg-5">

<div class="register-card">

<h2 class="register-title">
Create Your Account
</h2>

<form>

<div class="mb-3">
<label class="form-label">Full Name</label>
<input type="text" class="form-control" placeholder="Enter your full name">
</div>

<div class="mb-3">
<label class="form-label">Email Address</label>
<input type="email" class="form-control" placeholder="Enter your email">
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" class="form-control" placeholder="Create password">
</div>

<div class="mb-4">
<label class="form-label">Confirm Password</label>
<input type="password" class="form-control" placeholder="Confirm password">
</div>

<button class="btn btn-register w-100">
Create Account
</button>

</form>

<div class="text-center mt-4 signin-link">
Already have an account?
<a href="#">Sign In</a>
</div>

</div>

</div>

</div>

</div>
</section>
 <footer class="site-footer">
        <div class="container footer-container">

            <!-- About -->
            <div class="footer-about">
                <h3>HospiBridge</h3>
                <p>Your trusted healthcare partner, providing modern medical services with care and excellence.</p>
            </div>

            <!-- Quick Links -->
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ url('/index') }}">Home</a></li>
                    <li><a href="{{ url(path: '/services') }}">Services</a></li>
                    <li><a href="{{ url('/appointments') }}">Appointments</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-contact">
                <h4>Contact Us</h4>
                <p><i class="fas fa-map-marker-alt"></i> Beirut, Lebanon</p>
                <p><i class="fas fa-phone"></i> +961 70 123 456</p>
                <p><i class="fas fa-envelope"></i> info@hospibridge.com</p>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

        </div>

        <!-- Bottom -->
        <div class="footer-bottom">
            <p>© 2025 HospiBridge. All Rights Reserved.</p>
        </div>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>