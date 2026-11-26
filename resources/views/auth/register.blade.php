@extends('layouts.app')

@section('content')
<section class="hero auth-hero">
    <div class="hero-content">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="badge-ai">
                    <i class="fas fa-user-plus"></i>
                    Join HospiBridge
                </div>
                <h2 class="hero-title">Join HospiBridge</h2>
                <p class="hero-text">Create an account to book appointments, access records and receive personalized healthcare support through HospiBridge.</p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-robot"></i>
                            <h5>AI Triage</h5>
                            <p>Smart symptom guidance.</p>
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
                            <i class="fas fa-file-medical"></i>
                            <h5>Medical Records</h5>
                            <p>Secure access anytime.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 ms-auto">
                <div class="contact-card">
                    <h2 class="contact-title">Create Your Account</h2>

                    <form method="POST" action="{{ route('register.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" class="form-control" type="password" name="password" placeholder="Create a password" required autocomplete="new-password">
                            @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Confirm your password" required>
                        </div>

                        <button type="submit" class="btn btn-contact w-100">Create Account</button>
                    </form>

                    <div class="text-center mt-3">
                        <small>Already have an account? <a href="{{ route('login') }}">Sign in</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
