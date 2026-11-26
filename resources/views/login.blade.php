@extends('layouts.app')

@section('content')
<div class="auth-section">
    <div class="auth-card">
        <div class="auth-badge">❤</div>

        <h1 class="auth-title">Login</h1>
        <p class="auth-subtitle">Welcome back. Please enter your account details.</p>

        <form>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" placeholder="Enter your email">
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" placeholder="Enter your password">
            </div>

            <button type="submit" class="btn-main">Login</button>
        </form>

        <div class="bottom-text">
            Don’t have an account?
            <a href="/register">Create Account</a>
        </div>
    </div>
</div>
@endsection