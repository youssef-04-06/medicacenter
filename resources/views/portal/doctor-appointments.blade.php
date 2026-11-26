@extends('portal.layout')
@section('title', 'Doctor Appointments')
@section('content')
    <header class="portal-header">
        <div>
            <span class="portal-eyebrow">Doctor workspace</span>
            <h1>Appointments</h1>
            <p>Review the appointments assigned to your practice.</p>
        </div>
        <a class="portal-header-action" href="{{ route('home') }}#appointment"><i class="fas fa-calendar-plus"></i> View availability</a>
    </header>

    <section class="portal-panel">
        <div class="portal-panel-heading"><div><h2>Patient appointments</h2><p>Prescription requests are managed separately under Prescriptions.</p></div></div>
        <div class="portal-table-wrap">
            <table class="portal-table">
                <thead><tr><th>Patient</th><th>Visit</th><th>Schedule</th><th>Status</th><th>Prescription</th></tr></thead>
                <tbody>
                    @forelse ($appointments as $appointment)
                        <tr>
                            <td><strong>{{ $appointment->name ?: ($appointment->user->name ?? 'Unknown') }}</strong><small>{{ $appointment->email }}</small><small>{{ $appointment->phone ?: 'No phone provided' }}</small></td>
                            <td>{{ ucfirst($appointment->appointment_type ?? 'normal') }}</td>
                            <td>{{ $appointment->schedule->date ?? 'Pending' }}<small>{{ $appointment->schedule->start_time ?? 'Time pending' }}</small></td>
                            <td><span class="portal-badge {{ $appointment->status }}">{{ $appointment->status }}</span></td>
                            <td>
                                @if ($appointment->user_id)
                                    <button type="button" class="portal-button secondary" onclick="document.getElementById('rx-form-{{ $appointment->id }}').hidden = !document.getElementById('rx-form-{{ $appointment->id }}').hidden"><i class="fas fa-prescription-bottle-medical"></i> {{ $appointment->prescription ? 'Update' : 'Prescribe' }}</button>
                                    <form id="rx-form-{{ $appointment->id }}" class="portal-inline-form" method="POST" action="{{ route('appointments.prescriptions.store', $appointment) }}" hidden>
                                        @csrf
                                        <input type="text" name="medication" placeholder="Medication" required>
                                        <input type="text" name="dosage" placeholder="Dosage" required>
                                        <textarea name="instructions" placeholder="Instructions" required></textarea>
                                        <button class="portal-button" type="submit">Save prescription</button>
                                    </form>
                                @else
                                    <span class="portal-detail-label">Patient account required</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="portal-empty"><i class="fas fa-calendar-xmark"></i><p>No appointments assigned yet.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:18px">{{ $appointments->links() }}</div>
    </section>
@endsection
