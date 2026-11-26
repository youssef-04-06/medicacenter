@extends('portal.layout')
@section('title', 'Payments')
@section('content')
<header class="portal-header"><div><span class="portal-eyebrow">Patient portal</span><h1>Payments</h1><p>Track payment references connected to your telemedicine appointments.</p></div></header>
<section class="portal-panel"><div class="portal-panel-heading"><div><h2>Payment history</h2><p>Payment status updates from the care team appear here.</p></div></div>
<div class="portal-table-wrap"><table class="portal-table"><thead><tr><th>Appointment</th><th>Doctor</th><th>Method</th><th>Reference</th><th>Amount</th><th>Status</th></tr></thead><tbody>
@forelse ($payments as $payment)<tr><td>{{ ucfirst($payment->appointment->appointment_type ?? 'appointment') }}<small>{{ $payment->created_at->format('M d, Y') }}</small></td><td>{{ $payment->doctor ? 'Dr. ' . $payment->doctor->name : 'Pending' }}</td><td>{{ ucfirst($payment->payment_method) }}</td><td>{{ $payment->reference ?: 'Not provided' }}</td><td>${{ number_format((float) $payment->amount, 2) }}</td><td><span class="portal-badge {{ $payment->status === 'verified' ? 'completed' : ($payment->status === 'rejected' ? 'rejected' : 'pending') }}">{{ $payment->status }}</span></td></tr>@empty<tr><td colspan="6"><div class="portal-empty"><i class="fas fa-wallet"></i><p>No payments recorded yet.</p></div></td></tr>@endforelse
</tbody></table></div></section>
@endsection
