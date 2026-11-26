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

    <section class="patient-hero">
        <div class="patient-hero-overlay"></div>
        <div class="container patient-hero-content">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-8">
                    <div class="patient-hero-panel" data-aos="fade-up">
                        <span class="hero-badge">Doctor Portal</span>
                        <h1 class="patient-hero-title">Welcome back, Dr. {{ $doctor->name }}</h1>
                        <p class="patient-hero-text">Review every patient booked with you, track visit status, join telemedicine calls, and issue prescriptions from one place.</p>

                        <div class="row g-3 patient-meta-row">
                            <div class="col-md-6">
                                <div class="patient-meta-card">
                                    <span>Specialty</span>
                                    <strong>{{ $doctor->specialty ?: 'Not specified' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="patient-meta-card">
                                    <span>Email</span>
                                    <strong>{{ $doctor->email ?: 'Not set' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="patient-side-stack" data-aos="fade-left">
                        <div class="patient-stat-card">
                            <span>Total Appointments</span>
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
            @if (session('error'))
                <div class="patient-alert error-alert">{{ session('error') }}</div>
            @endif

            <div class="patient-block" data-aos="fade-up">
                <div class="patient-block-header">
                    <div>
                        <span class="section-kicker">My Patients</span>
                        <h2>Appointments booked with you</h2>
                        <p>Every appointment assigned to you appears here with patient contact details, visit notes, and telemedicine access.</p>
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
                                            <strong>{{ $appointment->name ?: ($appointment->user->name ?? 'Unknown') }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="patient-detail-card">
                                            <span>Contact</span>
                                            <strong>{{ $appointment->email }}</strong>
                                            <small>{{ $appointment->phone ?: 'No phone provided' }}</small>
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
                                @if (strtolower((string) ($appointment->appointment_type ?? 'normal')) === 'telemedicine' && in_array($appointment->status, ['accepted', 'confirmed'], true) && ($appointment->zoom_start_url || $appointment->zoom_join_url || $appointment->zoom_meeting_link))
                                    <p><strong>Meeting:</strong> <a href="{{ $appointment->zoom_start_url ?: ($appointment->zoom_join_url ?: $appointment->zoom_meeting_link) }}" target="_blank" rel="noopener noreferrer">Start Zoom Meeting (Host)</a></p>
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
                                @if (!empty($details['allergies']))
                                    <p><strong>Allergies:</strong> {{ $details['allergies'] }}</p>
                                @endif
                                @if (!empty($details['whish_reference']))
                                    <p><strong>Whish payment ref:</strong> {{ $details['whish_reference'] }}</p>
                                @endif
                                @if (!empty($details['message']))
                                    <p><strong>Message:</strong> {{ $details['message'] }}</p>
                                @endif

                                @if ($appointment->prescription)
                                    <p><strong>Prescription on file.</strong></p>
                                @endif

                                @if ($appointment->user_id)
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="document.getElementById('rx-form-{{ $appointment->id }}').classList.toggle('d-none')">
                                        {{ $appointment->prescription ? 'Update prescription' : 'Write prescription' }}
                                    </button>
                                    <form id="rx-form-{{ $appointment->id }}" class="mt-2 d-none" method="POST" action="{{ route('appointments.prescriptions.store', $appointment) }}">
                                        @csrf
                                        <input type="text" name="medication" class="form-control form-control-sm mb-1" placeholder="Medication" required>
                                        <input type="text" name="dosage" class="form-control form-control-sm mb-1" placeholder="Dosage" required>
                                        <textarea name="instructions" class="form-control form-control-sm mb-1" placeholder="Instructions" required></textarea>
                                        <button type="submit" class="btn btn-primary btn-sm">Save prescription</button>
                                    </form>
                                @else
                                    <p class="text-muted small mt-2">Patient must have a linked account before a prescription can be issued.</p>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="patient-empty-state">
                            <h3>No appointments yet</h3>
                            <p>Once the admin assigns patients to you, they will appear here.</p>
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
