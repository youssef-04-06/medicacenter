@extends('admin.layout')

@section('title', 'Appointments')

@section('content')
    <div class="topbar">
        <div>
            <span class="page-kicker">Care coordination</span>
            <h1>Appointments</h1>
            <p class="page-subtitle">Review requests, confirm visits, and keep patient communication moving.</p>
        </div>
    </div>

    <div class="filter-bar">
        <a href="{{ route('admin.appointments.index') }}" class="{{ request('status') ? '' : 'active' }}">All</a>
        <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="{{ request('status') === 'pending' ? 'active' : '' }}">Pending</a>
        <a href="{{ route('admin.appointments.index', ['status' => 'accepted']) }}" class="{{ request('status') === 'accepted' ? 'active' : '' }}">Accepted</a>
        <a href="{{ route('admin.appointments.index', ['status' => 'completed']) }}" class="{{ request('status') === 'completed' ? 'active' : '' }}">Completed</a>
        <a href="{{ route('admin.appointments.index', ['status' => 'rejected']) }}" class="{{ request('status') === 'rejected' ? 'active' : '' }}">Rejected</a>
    </div>

    <div class="table-container appointments-panel">
        <table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Contact</th>
                    <th>Type</th>
                    <th>Source</th>
                    <th>Reason</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->name }}</td>
                        <td>{{ $appointment->email }}<br><small>{{ $appointment->phone }}</small></td>
                        <td>{{ ucfirst($appointment->appointment_type ?? 'normal') }}</td>
                        <td>
                            @php
                                $type = strtolower((string) ($appointment->appointment_type ?? 'normal'));
                                $msg = strtolower((string) ($appointment->message ?? ''));
                                if ($type === 'telemedicine') {
                                    $source = 'Telemedicine';
                                } elseif ($type === 'vaccination') {
                                    $source = 'Vaccination';
                                } elseif (str_contains($msg, 'quantum health ai chatbot') || str_contains($msg, 'booked via')) {
                                    $source = 'AI Chatbot';
                                } else {
                                    $source = 'Services Form';
                                }
                            @endphp
                            {{ $source }}
                        </td>
                        <td>
                            @php
                                $fullMessage = (string) ($appointment->message ?? '');
                                $reason = trim($fullMessage);

                                if (preg_match('/Symptoms:\s*(.*)$/i', $fullMessage, $m)) {
                                    $reason = trim($m[1]);
                                } elseif (preg_match('/Symptoms\/Situation:\s*(.*)$/i', $fullMessage, $m)) {
                                    $reason = trim($m[1]);
                                } elseif (preg_match('/Message:\s*(.*)$/i', $fullMessage, $m)) {
                                    $reason = trim($m[1]);
                                }

                                if ($reason === '') {
                                    $reason = 'General appointment request';
                                }
                            @endphp
                            <small>{{ \Illuminate\Support\Str::limit($reason, 80) }}</small>
                        </td>
                        <td>{{ $appointment->doctor->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->schedule->date ?? 'N/A' }}</td>
                        <td>{{ $appointment->schedule->start_time ?? 'N/A' }}</td>
                        <td>
                            <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="status-select" onchange="this.form.submit()">
                                    @foreach (['pending', 'accepted', 'rejected', 'completed'] as $status)
                                        <option value="{{ $status }}" @selected($appointment->status === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            @if (strtolower((string) ($appointment->appointment_type ?? 'normal')) === 'telemedicine')
                                @php($whishRef = $appointment->appointment_details['whish_reference'] ?? null)
                                @php($whishNumber = $appointment->appointment_details['whish_number'] ?? null)
                                @if ($whishRef || $whishNumber)
                                    <div style="margin-bottom:8px; padding:6px 8px; border-radius:8px; background:#f5f3ff; border:1px solid #ddd6fe;">
                                        <small style="display:block; color:#5b21b6; font-weight:700;">Whish payment</small>
                                        @if ($whishNumber)<small style="display:block; color:#4c3d63;">From: {{ $whishNumber }}</small>@endif
                                        @if ($whishRef)<small style="display:block; color:#4c3d63;">Ref: {{ $whishRef }}</small>@endif
                                    </div>
                                @endif
                                <div style="margin-bottom:8px;">
                                    <small style="display:block; margin-bottom:4px; color:#475569;">Zoom links</small>
                                    @if ($appointment->zoom_join_url)
                                        <a href="{{ $appointment->zoom_join_url }}" target="_blank" rel="noopener noreferrer" style="display:inline-block; margin-bottom:6px; color:#0f766e; word-break:break-all;">
                                            Join: {{ $appointment->zoom_join_url }}
                                        </a>
                                    @endif
                                    @if ($appointment->zoom_start_url)
                                        <a href="{{ $appointment->zoom_start_url }}" target="_blank" rel="noopener noreferrer" style="display:inline-block; margin-bottom:6px; color:#0369a1; word-break:break-all;">
                                            Start: {{ $appointment->zoom_start_url }}
                                        </a>
                                    @endif
                                    @if (!$appointment->zoom_join_url && !$appointment->zoom_start_url)
                                        <small style="display:block; color:#64748b;">No Zoom links yet. Click Accept to generate them.</small>
                                    @endif
                                    @if ($appointment->status === 'accepted' && !$appointment->zoom_join_url && !$appointment->zoom_start_url)
                                        <small style="display:block; margin-top:4px; color:#b45309;">This appointment was accepted without Zoom links. Please configure ZOOM_ACCOUNT_ID, ZOOM_CLIENT_ID, and ZOOM_CLIENT_SECRET in .env, then re-accept to generate links.</small>
                                    @endif
                                </div>
                            @endif

                            @if ($appointment->status === 'pending')
                                <form action="{{ route('admin.appointments.accept', $appointment) }}" method="POST" style="margin-bottom:8px;">
                                    @csrf
                                    <label for="duration-{{ $appointment->id }}" style="display:block; margin-bottom:6px; color:#475569; font-size:12px;">Meeting duration (minutes)</label>
                                    <input id="duration-{{ $appointment->id }}" type="number" name="duration" value="30" min="15" max="180" class="status-select" style="display:block; width:100%; margin-bottom:8px;" placeholder="Meeting duration in minutes">
                                    <small style="display:block; margin-bottom:8px; color:#64748b;">This +/- control sets Zoom meeting length. The Zoom links appear after acceptance.</small>
                                    <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                </form>

                                <form action="{{ route('admin.appointments.reject', $appointment) }}" method="POST" style="margin-bottom:8px;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                </form>
                            @endif

                            @if ($appointment->status === 'accepted')
                                <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" style="margin-bottom:8px;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn btn-sm btn-primary">Mark Completed</button>
                                </form>
                            @endif

                            @if ($appointment->phone)
                                <a href="{{ route('admin.appointments.whatsapp', $appointment) }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm" style="display:inline-block; margin-bottom:8px; background:#25D366; color:#fff;">Send WhatsApp</a>
                            @endif

                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Delete this appointment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="empty-state">No appointments found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $appointments->links() }}</div>
    </div>
@endsection
