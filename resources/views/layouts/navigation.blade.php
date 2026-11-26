<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container-fluid navbar-inner">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <svg class="navbar-generated-logo" viewBox="0 0 330 92" role="img" aria-label="HospiBridge - Trusted Care Anytime">
                <defs>
                    <linearGradient id="hospiLogoBlue" x1="0" y1="0" x2="1" y2="0">
                        <stop offset="0" stop-color="#0077b6" />
                        <stop offset="1" stop-color="#00a8e8" />
                    </linearGradient>
                    <linearGradient id="hospiLogoCyan" x1="0" y1="0" x2="1" y2="0">
                        <stop offset="0" stop-color="#00b4d8" />
                        <stop offset="1" stop-color="#0077b6" />
                    </linearGradient>
                </defs>
                <text x="3" y="42" class="generated-logo-hospi">Hosp</text>
                <path d="M122 18c0-9 7-14 14-14s14 5 14 14" class="generated-logo-stethoscope" />
                <path d="M136 18v27c0 8 5 12 12 12 7 0 12-4 12-12V35" class="generated-logo-stethoscope" />
                <circle cx="160" cy="31" r="3" class="generated-logo-stethoscope-dot" />
                <text x="171" y="42" class="generated-logo-bridge">Bridge</text>
                <path d="M4 57h43l10-12 12 16 12-16 12 12h230" class="generated-logo-pulse" />
                <text x="5" y="78" class="generated-logo-tagline">TRUSTED CARE · ANYTIME</text>
            </svg>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-5 mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif><svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/><path d="M9 21v-6h6v6"/></svg><span>Home</span></a>
                </li>
                <li class="nav-item ms-4">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}" @if (request()->routeIs('services')) aria-current="page" @endif><svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 21h18"/><path d="M5 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16"/><path d="M15 9h4a2 2 0 0 1 2 2v10"/><path d="M9 7h2M9 11h2M9 15h2M18 13h1M18 17h1"/></svg><span>Services</span></a>
                </li>
                <li class="nav-item ms-4">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}" @if (request()->routeIs('contact')) aria-current="page" @endif><svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg><span>Contact</span></a>
                </li>
            </ul>
            <span class="navbar-gap-bridge" aria-hidden="true">
                <svg viewBox="0 0 120 42">
                    <path class="bridge-glow" d="M4 35h112M13 35V8M27 35V8M93 35V8M107 35V8M13 8h14M93 8h14" />
                    <path d="M13 8C25 8 32 30 60 30S95 8 107 8" />
                    <path d="M13 8C30 8 36 3 60 3s30 5 47 5" />
                    <path d="M20 12v23M28 16v19M36 21v14M44 25v10M52 28v7M68 28v7M76 25v10M84 21v14M92 16v19M100 12v23" />
                    <path d="M7 35h106" stroke-width="3" />
                    <path d="M7 39h106" stroke-width="1" opacity="0.5" />
                    <path d="M13 35v4M107 35v4" />
                </svg>
            </span>
            <div class="navbar-actions d-flex align-items-center gap-3 ms-auto">
                <form class="d-flex" role="search" method="GET" action="{{ route('services') }}">
                    <input class="form-control search-input" type="search" name="q" value="{{ request('q') }}" placeholder="Search services..." aria-label="Search services">
                    <button class="btn btn-search" type="submit" aria-label="Search"><svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg></button>
                </form>
                @auth
                    <div class="d-flex align-items-center gap-2">
                        @if (Auth::user()->is_admin)
                            <a class="nav-link nav-link-login" href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge me-1"></i>Admin</a>
                        @elseif (strtolower((string) Auth::user()->role) === 'doctor' && Auth::user()->doctor)
                            <a class="nav-link nav-link-login" href="{{ route('doctor.dashboard') }}"><i class="fas fa-stethoscope me-1"></i>My Patients</a>
                        @else
                            <a class="nav-link nav-link-login" href="{{ route('my-appointments') }}"><i class="fas fa-calendar-check me-1"></i>My Appointments</a>
                        @endif
                        <a class="nav-link nav-link-login" href="#">{{ Auth::user()->name }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-secondary btn-sm" type="submit">Logout</button>
                        </form>
                    </div>
                @else
                    <a class="nav-link nav-link-login" href="{{ route('login') }}"><svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="m10 17 5-5-5-5M15 12H3"/></svg><span>Login</span></a>
                    <a class="btn btn-register" href="{{ route('register') }}"><svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M19 8v6M22 11h-6"/></svg><span>Register</span></a>
                @endauth
                <div class="d-flex ms-3 social-icons-nav">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>
</nav>
