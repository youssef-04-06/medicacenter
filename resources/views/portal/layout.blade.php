<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') · HospiBridge</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body class="portal-body">
    <aside class="portal-sidebar">
        <a class="portal-brand" href="{{ route('home') }}"><span class="portal-brand-mark"><i class="fas fa-plus"></i></span><span>HospiBridge</span></a>
        <nav class="portal-nav" aria-label="Dashboard navigation">
            <span class="portal-nav-label">Workspace</span>
            @if (auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge"></i> Admin dashboard</a>
            @elseif (strtolower((string) auth()->user()->role) === 'doctor' && auth()->user()->doctor)
                <a class="{{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}" href="{{ route('doctor.dashboard') }}"><i class="fas fa-gauge"></i> Dashboard</a>
                <a class="{{ request()->routeIs('doctor.appointments') ? 'active' : '' }}" href="{{ route('doctor.appointments') }}"><i class="fas fa-calendar-check"></i> Appointments</a>
                <a class="{{ request()->routeIs('doctor.prescriptions') ? 'active' : '' }}" href="{{ route('doctor.prescriptions') }}"><i class="fas fa-prescription-bottle-medical"></i> Prescriptions</a>
                <a class="{{ request()->routeIs('doctor.payments') ? 'active' : '' }}" href="{{ route('doctor.payments') }}"><i class="fas fa-wallet"></i> Payments</a>
                <a class="{{ request()->routeIs('doctor.messages*') ? 'active' : '' }}" href="{{ route('doctor.messages') }}"><i class="fas fa-comments"></i> Messages</a>
                <a href="{{ route('home') }}#appointment"><i class="fas fa-calendar-plus"></i> Availability</a>
            @else
                <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="fas fa-gauge"></i> Dashboard</a>
                <a href="{{ route('services') }}"><i class="fas fa-calendar-plus"></i> Book appointment</a>
                <a href="{{ route('my-appointments') }}"><i class="fas fa-calendar-check"></i> My appointments</a>
                <a href="{{ route('prescriptions') }}" class="{{ request()->routeIs('prescriptions') ? 'active' : '' }}"><i class="fas fa-prescription-bottle-medical"></i> Prescriptions</a>
                <a href="{{ route('payments') }}" class="{{ request()->routeIs('payments') ? 'active' : '' }}"><i class="fas fa-wallet"></i> Payments</a>
                <a href="{{ route('messages') }}" class="{{ request()->routeIs('messages*') ? 'active' : '' }}"><i class="fas fa-comments"></i> Messages</a>
            @endif
            <a href="{{ route('home') }}"><i class="fas fa-globe"></i> View website</a>
        </nav>
        <div class="portal-sidebar-footer">
            <div class="portal-user-mini"><span class="portal-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><span><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->is_admin ? 'Administrator' : (strtolower((string) auth()->user()->role) === 'doctor' ? 'Doctor' : 'Patient') }}</small></span></div>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="portal-logout" type="submit"><i class="fas fa-right-from-bracket"></i> Log out</button></form>
        </div>
    </aside>
    <main class="portal-main">
        @if (session('success'))<div class="portal-alert success">{{ session('success') }}</div>@endif
        @if (session('error'))<div class="portal-alert error">{{ session('error') }}</div>@endif
        @yield('content')
    </main>
</body>
</html>