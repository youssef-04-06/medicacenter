@extends('layouts.app')

@section('content')
<style>
body {
    background: linear-gradient(135deg, #eef8fc 0%, #dceff5 50%, #cfe7ef 100%);
}

.hero {
    min-height: auto;
    display: flex;
    align-items: center;
    padding: 48px 0 56px;
    margin-bottom: 0;
}

.badge-ai {
    background: rgba(255,255,255,.9);
    color: #0077b6;
    border: 1px solid rgba(0,180,216,.15);
    padding: 12px 22px;
    border-radius: 50px;
    display: inline-flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 25px;
    font-weight: 600;
    box-shadow: 0 5px 20px rgba(0,119,182,.08);
}

.hero-title {
    font-size: 4rem;
    font-weight: 900;
    line-height: 1.1;
    color: #0077b6;
}

.hero-title span {
    background: linear-gradient(90deg, #00b4d8, #0077b6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero-text {
    color: #555;
    font-size: 1.1rem;
    line-height: 1.8;
    margin: 20px 0 40px;
}

.feature-card {
    background: rgba(255,255,255,.65);
    border: 1px solid rgba(255,255,255,.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 25px;
    height: 100%;
    transition: .4s;
    box-shadow: 0 8px 25px rgba(0,119,182,.08);
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,119,182,.15);
}

.feature-card i {
    color: #00b4d8;
    font-size: 2rem;
    margin-bottom: 15px;
}

.feature-card h5 {
    color: #0077b6;
    font-weight: 700;
}

.feature-card p {
    color: #666;
    margin-bottom: 0;
}

.contact-card {
    background: rgba(255,255,255,.85);
    border: 1px solid rgba(255,255,255,.95);
    backdrop-filter: blur(20px);
    border-radius: 30px;
    padding: 40px;
    box-shadow: 0 15px 40px rgba(0,119,182,.12);
}

.contact-title {
    color: #0077b6;
    text-align: center;
    margin-bottom: 30px;
    font-weight: 800;
}

.form-label {
    color: #0077b6;
    font-weight: 600;
}

.form-control {
    background: #fff;
    border: 1px solid #d9e8ef;
    color: #333;
    padding: 14px;
    border-radius: 14px;
}

.form-control:focus {
    background: #fff;
    color: #333;
    border-color: #00b4d8;
    box-shadow: 0 0 15px rgba(0,180,216,.15);
}

.form-control::placeholder {
    color: #999;
}

.btn-contact {
    background: linear-gradient(135deg, #00b4d8, #0077b6);
    border: none;
    color: white;
    padding: 14px;
    border-radius: 30px;
    font-weight: 700;
    transition: .3s;
}

.btn-contact:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,119,182,.25);
}

.contact-info {
    margin-top: 30px;
}

.contact-info div {
    margin-bottom: 15px;
    color: #555;
}

.contact-info i {
    color: #00b4d8;
    width: 25px;
}

@media (max-width: 991px) {
    .hero {
        padding: 60px 0;
    }

    .hero-title {
        font-size: 2.8rem;
    }

    .contact-card {
        margin-top: 40px;
    }
}
</style>

<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <div class="badge-ai">
                    <i class="fas fa-envelope"></i>
                    Contact HospiBridge
                </div>
                <h1 class="hero-title">
                    We're Here To <span>Help You</span>
                </h1>
                <p class="hero-text">
                    Contact our healthcare team for support, appointments, medical inquiries and healthcare guidance.
                    Our specialists are always ready to assist you.
                </p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-phone"></i>
                            <h5>24/7 Support</h5>
                            <p>Reach us anytime.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-calendar-check"></i>
                            <h5>Appointments</h5>
                            <p>Easy scheduling.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-location-dot"></i>
                            <h5>Visit Us</h5>
                            <p>Beirut, Lebanon.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contact-card">
                    <h2 class="contact-title">Send Message</h2>
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Message</label>
                            <textarea name="message" rows="5" class="form-control" placeholder="Write your message..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-contact w-100">Send Message</button>
                    </form>
                    <div class="text-center mt-4">
                        Need an appointment? <a href="{{ route('register') }}">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
