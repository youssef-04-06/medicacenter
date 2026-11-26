@extends('layouts.app')

@section('content')
<section class="hero auth-hero">
    <div class="hero-content">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <div class="badge-ai">
                    <i class="fas fa-sign-in-alt"></i>
                    Access HospiBridge
                </div>
                <h1 class="hero-title">Welcome <span>Back</span></h1>
                <p class="hero-text">Sign in to manage appointments, access medical records and continue your personalized healthcare journey.</p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-calendar-check"></i>
                            <h5>Appointments</h5>
                            <p>Manage visits easily.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-file-medical"></i>
                            <h5>Medical Records</h5>
                            <p>Secure access anytime.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-headset"></i>
                            <h5>Support</h5>
                            <p>Care when you need it.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="contact-card">
                    <h2 class="contact-title">Sign In</h2>

                    <x-auth-session-status class="mb-3 text-white" :status="session('status')" />

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" class="form-control" type="password" name="password" placeholder="Enter your password" required>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label class="form-check-label" for="remember_me">Remember me</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Forgot your password?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-contact w-100">Log in</button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="mb-0">Don’t have an account? <a href="{{ route('register') }}">Register now</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
