@extends('portal.layout')
@section('title', 'Doctor Prescriptions')
@section('content')
    <header class="portal-header">
        <div>
            <span class="portal-eyebrow">Doctor workspace</span>
            <h1>Prescriptions</h1>
            <p>Review requests assigned to you and issue prescriptions for your patients.</p>
        </div>
    </header>

    <section class="portal-panel">
        <div class="portal-panel-heading"><div><h2>Prescription requests</h2><p>Only requests where patients selected you are shown here.</p></div></div>
        <div class="portal-table-wrap">
            <table class="portal-table">
                <thead><tr><th>Patient</th><th>Request</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($prescriptionRequests as $prescriptionRequest)
                        <tr>
                            <td><strong>{{ $prescriptionRequest->name ?: ($prescriptionRequest->user->name ?? 'Unknown') }}</strong><small>{{ $prescriptionRequest->email }}</small><small>{{ $prescriptionRequest->phone ?: 'No phone provided' }}</small></td>
                            <td style="white-space:pre-wrap">{{ $prescriptionRequest->message ?: 'No details provided.' }}</td>
                            <td><span class="portal-badge {{ $prescriptionRequest->prescription ? 'completed' : 'pending' }}">{{ $prescriptionRequest->prescription ? 'Issued' : 'Pending' }}</span></td>
                            <td>
                                @if ($prescriptionRequest->user_id)
                                    <button type="button" class="portal-button secondary" onclick="document.getElementById('rx-request-form-{{ $prescriptionRequest->id }}').hidden = !document.getElementById('rx-request-form-{{ $prescriptionRequest->id }}').hidden"><i class="fas fa-prescription-bottle-medical"></i> {{ $prescriptionRequest->prescription ? 'Update' : 'Prescribe' }}</button>
                                    <form id="rx-request-form-{{ $prescriptionRequest->id }}" class="portal-inline-form" method="POST" action="{{ route('appointments.prescriptions.store', $prescriptionRequest) }}" hidden>
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
                        <tr><td colspan="4"><div class="portal-empty"><i class="fas fa-prescription-bottle-medical"></i><p>No prescription requests assigned to you.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:18px">{{ $prescriptionRequests->links() }}</div>
    </section>
@endsection
