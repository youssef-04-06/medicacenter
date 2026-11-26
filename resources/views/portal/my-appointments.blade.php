@extends('portal.layout')
@section('title', 'My Appointments')
@section('content')
    <header class="portal-header">
        <div>
            <span class="portal-eyebrow">Patient portal</span>
            <h1>My appointments</h1>
            <p>Track your bookings, visit details, and appointment status.</p>
        </div>
        <a class="portal-header-action" href="{{ route('services') }}"><i class="fas fa-calendar-plus"></i> Book appointment</a>
    </header>

    <section class="portal-panel">
        <div class="portal-panel-heading">
            <div>
                <h2>Appointment history</h2>
                <p>Prescription requests are managed separately in My prescriptions.</p>
            </div>
        </div>
        <div class="portal-table-wrap">
            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Appointment</th>
                        <th>Doctor</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $appointment)
                        @php($details = $appointment->appointment_details ?? [])
                        <tr>
                            <td><strong>{{ ucfirst($appointment->appointment_type ?? 'normal') }}</strong><small>{{ $appointment->created_at->format('M d, Y') }}</small></td>
                            <td>{{ $appointment->doctor->name ?? 'Pending assignment' }}</td>
                            <td>{{ $appointment->schedule->date ?? 'Pending' }}<small>{{ $appointment->schedule->start_time ?? 'Time pending' }}</small></td>
                            <td><span class="portal-badge {{ $appointment->status }}">{{ $appointment->status }}</span></td>
                            <td>
                                @if (!empty($details['symptoms']))<small><strong>Symptoms:</strong> {{ $details['symptoms'] }}</small>@endif
                                @if (!empty($details['message']))<small><strong>Message:</strong> {{ $details['message'] }}</small>@endif
                                @if (strtolower((string) ($appointment->appointment_type ?? 'normal')) === 'telemedicine' && in_array($appointment->status, ['accepted', 'confirmed'], true) && ($appointment->zoom_join_url || $appointment->zoom_meeting_link))
                                    <a class="portal-link" href="{{ $appointment->zoom_join_url ?: $appointment->zoom_meeting_link }}" target="_blank" rel="noopener noreferrer">Join Zoom Meeting</a>
                                @endif
                                @if (empty($details['symptoms']) && empty($details['message']))<span class="portal-detail-label">No extra details</span>@endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="portal-empty"><i class="fas fa-calendar-xmark"></i><p>No appointments yet. Book your first visit to get started.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:18px">{{ $appointments->links() }}</div>
    </section>
@endsection
