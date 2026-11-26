@extends('layouts.app')

@section('content')
    @php
        $nextAppointment = $appointments->first(function ($appointment) {
            return in_array($appointment->status, ['pending', 'accepted', 'confirmed'], true);
        });

        $statusClasses = [
            'pending' => 'status-pending',
            'confirmed' => 'status-confirmed',
            'accepted' => 'status-confirmed',
            'cancelled' => 'status-cancelled',
            'rejected' => 'status-cancelled',
            'completed' => 'status-completed',
        ];
    @endphp

    <section class="patient-hero">
        <div class="patient-hero-overlay"></div>
        <div class="container patient-hero-content">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-8">
                    <div class="patient-hero-panel" data-aos="fade-up">
                        <span class="hero-badge">Patient Portal</span>
                        <h1 class="patient-hero-title">Welcome back, {{ $user->name }}</h1>
                        <p class="patient-hero-text">Your HospiBridge dashboard now follows the same look and feel as the main website, with your bookings, telemedicine access, and quick actions in one place.</p>

                        <div class="patient-hero-actions">
                            <a href="{{ route('services') }}" class="btn btn-primary hero-cta">Book Appointment</a>
                            <a href="{{ route('home') }}" class="btn btn-outline-light hero-cta">Open AI Chat</a>
                        </div>

                        <div class="row g-3 patient-meta-row">
                            <div class="col-md-6">
                                <div class="patient-meta-card">
                                    <span>Email</span>
                                    <strong>{{ $user->email }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="patient-meta-card">
                                    <span>Account</span>
                                    <strong>Active patient account</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="patient-side-stack" data-aos="fade-left">
                        <div class="patient-stat-card">
                            <span>Total Bookings</span>
                            <strong>{{ $appointmentSummary['total'] }}</strong>
                        </div>
                        <div class="patient-stat-card accent-amber">
                            <span>Pending</span>
                            <strong>{{ $appointmentSummary['pending'] }}</strong>
                        </div>
                        <div class="patient-stat-card accent-green">
                            <span>Accepted</span>
                            <strong>{{ $appointmentSummary['accepted'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="patient-dashboard-section">
        <div class="container">
            @if (session('success'))
                <div class="patient-alert success-alert">{{ session('success') }}</div>
            @endif

            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                        <div class="patient-block" data-aos="fade-up">
                        <div class="patient-block-header">
                            <div>
                                <span class="section-kicker">Quick Actions</span>
                                <h2>Manage today’s care</h2>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="{{ route('services') }}" class="patient-action-card">
                                    <i class="fas fa-calendar-plus"></i>
                                    <h3>Book care</h3>
                                    <p>Reserve a new visit from the services page.</p>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('my-appointments') }}" class="patient-action-card">
                                    <i class="fas fa-notes-medical"></i>
                                    <h3>My bookings</h3>
                                    <p>Review appointment history and status updates.</p>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('home') }}" class="patient-action-card">
                                    <i class="fas fa-robot"></i>
                                    <h3>AI support</h3>
                                    <p>Ask for guidance before choosing a doctor or service.</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="patient-block next-visit-block" data-aos="fade-up" data-aos-delay="80">
                        <div class="patient-block-header compact-header">
                            <div>
                                <span class="section-kicker">Next Visit</span>
                                <h2>{{ $nextAppointment ? 'Upcoming appointment' : 'No booking yet' }}</h2>
                            </div>
                            <span class="patient-live-pill">Live</span>
                        </div>

                        @if ($nextAppointment)
                            <div class="patient-visit-card">
                                <span>Doctor</span>
                                <strong>{{ $nextAppointment->doctor->name ?? 'Pending assignment' }}</strong>
                            </div>
                            <div class="row g-3 mt-1">
                                <div class="col-6">
                                    <div class="patient-mini-card">
                                        <span>Date</span>
                                        <strong>{{ $nextAppointment->schedule->date ?? 'Pending' }}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="patient-mini-card">
                                        <span>Time</span>
                                        <strong>{{ $nextAppointment->schedule->start_time ?? 'Pending' }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="patient-type-pill mt-3">{{ ucfirst($nextAppointment->appointment_type ?? 'normal') }}</div>

                            @if (strtolower((string) ($nextAppointment->appointment_type ?? 'normal')) === 'telemedicine' && in_array($nextAppointment->status, ['accepted', 'confirmed'], true) && ($nextAppointment->zoom_join_url || $nextAppointment->zoom_meeting_link))
                                <a href="{{ $nextAppointment->zoom_join_url ?: $nextAppointment->zoom_meeting_link }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary hero-cta patient-join-btn mt-3">Join Zoom Meeting</a>
                            @endif
                        @else
                            <div class="patient-empty-note">
                                You do not have an upcoming appointment yet. Book a consultation, vaccination, or telemedicine visit to see it here.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="patient-block patient-history-block" data-aos="fade-up" data-aos-delay="120">
                <div class="patient-block-header">
                    <div>
                        <span class="section-kicker"><i class="fas fa-clock-rotate-left me-2"></i>History</span>
                        <h2>My appointments</h2>
                        <p>Every booking linked to your account appears here with doctor, schedule, status, and your submitted details.</p>
                    </div>
                </div>

                <div class="patient-appointments-list">
                    @forelse ($appointments as $appointment)
                        @php($details = $appointment->appointment_details ?? [])
                        <article class="patient-appointment-card">
                            <div class="patient-appointment-main">
                                <div class="patient-appointment-top">
                                    <h3>{{ ucfirst($appointment->appointment_type ?? 'normal') }} appointment</h3>
                                    <span class="patient-status-badge {{ $statusClasses[$appointment->status] ?? 'status-neutral' }}">{{ ucfirst($appointment->status) }}</span>
                                </div>

                                <div class="row g-3 mt-1">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="patient-detail-card">
                                            <span>Patient</span>
                                            <strong>{{ $appointment->name ?: $user->name }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="patient-detail-card">
                                            <span>Doctor</span>
                                            <strong>{{ $appointment->doctor->name ?? 'Pending assignment' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="patient-detail-card">
                                            <span>Date</span>
                                            <strong>{{ $appointment->schedule->date ?? 'Pending' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="patient-detail-card">
                                            <span>Time</span>
                                            <strong>{{ $appointment->schedule->start_time ?? 'Pending' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="patient-appointment-side">
                                <span class="section-kicker small">Details</span>
                                @if (strtolower((string) ($appointment->appointment_type ?? 'normal')) === 'telemedicine' && in_array($appointment->status, ['accepted', 'confirmed'], true) && ($appointment->zoom_join_url || $appointment->zoom_meeting_link))
                                    <p><strong>Meeting:</strong> <a href="{{ $appointment->zoom_join_url ?: $appointment->zoom_meeting_link }}" target="_blank" rel="noopener noreferrer">Join Zoom Meeting</a></p>
                                @endif
                                @if ($appointment->prescription)
                                    <p><strong>Prescription:</strong> <a href="{{ route('appointments.prescriptions.download', $appointment) }}">Download PDF</a></p>
                                @endif
                                @if (!empty($details['symptoms']))
                                    <p><strong>Symptoms:</strong> {{ $details['symptoms'] }}</p>
                                @endif
                                @if (!empty($details['location']))
                                    <p><strong>Location:</strong> {{ $details['location'] }}</p>
                                @endif
                                @if (!empty($details['urgency']))
                                    <p><strong>Urgency:</strong> {{ $details['urgency'] }}</p>
                                @endif
                                @if (!empty($details['vaccine_name']))
                                    <p><strong>Vaccine:</strong> {{ $details['vaccine_name'] }}</p>
                                @endif
                                @if (!empty($details['dose_number']))
                                    <p><strong>Dose:</strong> {{ $details['dose_number'] }}</p>
                                @endif
                                @if (!empty($details['allergies']))
                                    <p><strong>Allergies:</strong> {{ $details['allergies'] }}</p>
                                @endif
                                @if (!empty($details['whish_reference']))
                                    <p><strong>Whish payment ref:</strong> {{ $details['whish_reference'] }}</p>
                                @endif
                                @if (!empty($details['message']))
                                    <p><strong>Message:</strong> {{ $details['message'] }}</p>
                                @endif
                                @if (empty($details['symptoms']) && empty($details['location']) && empty($details['urgency']) && empty($details['vaccine_name']) && empty($details['dose_number']) && empty($details['allergies']) && empty($details['message']))
                                    <p>{{ \Illuminate\Support\Str::limit((string) ($appointment->message ?? 'No details provided'), 180) }}</p>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="patient-empty-state">
                            <h3>No appointments found yet</h3>
                            <p>Once you book your first consultation, it will appear here with status and visit details.</p>
                            <a href="{{ route('services') }}" class="btn btn-primary hero-cta">Book your first appointment</a>
                        </div>
                    @endforelse
                </div>

                <div class="patient-pagination mt-4">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
