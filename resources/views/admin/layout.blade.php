<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') · HospiBridge</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style22.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <svg width="42" height="42" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M32 4 L12 16 V36 C12 50 32 60 32 60 C32 60 52 50 52 36 V16 Z" fill="#00b4d8" />
                <path d="M32 20 v16 M24 28 h16" stroke="#ffffff" stroke-width="4" stroke-linecap="round" />
            </svg>
            <span>HospiBridge</span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-gauge"></i> Dashboard</a>
        <a href="{{ route('admin.doctors.index') }}" class="{{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}"><i class="fas fa-stethoscope"></i> Doctors</a>
        <a href="{{ route('admin.appointments.index') }}" class="{{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}"><i class="fas fa-calendar-check"></i> Appointments</a>
        <a href="{{ route('admin.prescriptions.index') }}" class="{{ request()->routeIs('admin.prescriptions.*') ? 'active' : '' }}"><i class="fas fa-prescription-bottle-medical"></i> Prescriptions</a>
        <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"><i class="fas fa-wallet"></i> Payments</a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Users</a>
        <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"><i class="fas fa-envelope"></i> Messages</a>
        <a href="{{ route('home') }}"><i class="fas fa-globe"></i> View Site</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:auto;">
            @csrf
            <button type="submit" style="width:100%; background:transparent; border:1px solid rgba(255,255,255,.4); margin-top:20px;"><i class="fas fa-right-from-bracket"></i> Log out</button>
        </form>
    </div>

    <!-- Main -->
    <div class="main">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
