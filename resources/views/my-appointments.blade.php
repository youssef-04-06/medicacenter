@extends('layouts.app')

@section('content')
    @php
        $statusClasses = [
            'pending' => 'status-pending',
            'confirmed' => 'status-confirmed',
            'accepted' => 'status-confirmed',
            'cancelled' => 'status-cancelled',
            'rejected' => 'status-cancelled',
            'completed' => 'status-completed',
        ];
    @endphp

    <section class="patient-subhero">
        <div class="container">
            <div class="patient-subhero-card" data-aos="fade-up">
                <span class="hero-badge">Appointments Center</span>
                <h1>My Appointments</h1>
                <p>Track every HospiBridge booking connected to your account, including confirmed telemedicine links after admin approval.</p>
            </div>
        </div>
    </section>

    <section class="patient-dashboard-section patient-appointments-page">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="patient-stat-card static-card">
                        <span>Total Bookings</span>
                        <strong>{{ $appointmentSummary['total'] }}</strong>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="patient-stat-card accent-amber static-card">
                        <span>Pending</span>
                        <strong>{{ $appointmentSummary['pending'] }}</strong>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="patient-stat-card accent-green static-card">
                        <span>Accepted</span>
                        <strong>{{ $appointmentSummary['accepted'] }}</strong>
                    </div>
                </div>
            </div>

            <div class="patient-block patient-history-block" data-aos="fade-up">
                <div class="patient-block-header">
                    <div>
                        <span class="section-kicker"><i class="fas fa-clock-rotate-left me-2"></i>History</span>
                        <h2>Appointment history</h2>
                        <p>All appointments booked with your email are shown here, including bookings made before account creation.</p>
                    </div>
                </div>

                <div class="patient-appointments-list">
                    @forelse ($appointments as $appointment)
                        @php($details = $appointment->appointment_details ?? [])
                        <article class="patient-appointment-card compact-history-card">
                            <div class="patient-appointment-main">
                                <div class="patient-appointment-top">
                                    <h3>{{ ucfirst($appointment->appointment_type ?? 'normal') }} appointment</h3>
                                    <span class="patient-status-badge {{ $statusClasses[$appointment->status] ?? 'status-neutral' }}">{{ ucfirst($appointment->status) }}</span>
                                </div>

                                <div class="row g-3 mt-1">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="patient-detail-card">
                                            <span>Patient</span>
                                            <strong>{{ $appointment->name ?: $user->name }}</strong>
                                            <small>{{ $appointment->email }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="patient-detail-card">
                                            <span>Doctor</span>
                                            <strong>{{ $appointment->doctor->name ?? 'Pending assignment' }}</strong>
                                            <small>{{ $appointment->phone ?: 'No phone provided' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <div class="patient-detail-card">
                                            <span>Date</span>
                                            <strong>{{ $appointment->schedule->date ?? 'Pending' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
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
                                    <p>{{ \Illuminate\Support\Str::limit((string) ($appointment->message ?? 'No details provided'), 150) }}</p>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="patient-empty-state">
                            <h3>No appointments found yet</h3>
                            <p>Your bookings will appear here as soon as you make one.</p>
                            <a href="{{ route('services') }}" class="btn btn-primary hero-cta">Go to services</a>
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
