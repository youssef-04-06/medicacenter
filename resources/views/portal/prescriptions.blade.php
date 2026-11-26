@extends('portal.layout')
@section('title', 'Prescriptions')
@section('content')
    <header class="portal-header">
        <div>
            <span class="portal-eyebrow">Patient portal</span>
            <h1>My prescriptions</h1>
            <p>Review prescriptions issued by your care team and download a PDF copy.</p>
        </div>
        <a class="portal-header-action" href="{{ route('services') }}"><i class="fas fa-file-prescription"></i> Request prescription</a>
    </header>

    <section class="portal-panel">
        <div class="portal-panel-heading">
            <div>
                <h2>Issued prescriptions</h2>
                <p>Your prescription records are kept here separately from appointment history.</p>
            </div>
        </div>

        <div class="portal-prescription-grid">
            @forelse ($prescriptions as $appointment)
                <article class="portal-prescription-card">
                    <div class="portal-prescription-card-header">
                        <div>
                            <span class="portal-eyebrow">Prescription #{{ $appointment->prescription->id }}</span>
                            <h3>{{ $appointment->doctor ? 'Dr. ' . $appointment->doctor->name : 'Care team' }}</h3>
                        </div>
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <dl class="portal-detail-list">
                        <div><dt>Issued</dt><dd>{{ $appointment->prescription->created_at->format('M d, Y') }}</dd></div>
                        <div><dt>Visit date</dt><dd>{{ $appointment->schedule->date ?? 'Not linked to a visit' }}</dd></div>
                    </dl>
                    <div class="portal-prescription-content">{{ $appointment->prescription->content }}</div>
                    <a class="portal-button" href="{{ route('appointments.prescriptions.download', $appointment) }}"><i class="fas fa-download"></i> Download PDF</a>
                </article>
            @empty
                <div class="portal-empty">
                    <i class="fas fa-prescription-bottle-medical"></i>
                    <p>No prescriptions are available yet. Issued prescriptions will appear here.</p>
                    <a class="portal-button" href="{{ route('services') }}">Request a prescription</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
