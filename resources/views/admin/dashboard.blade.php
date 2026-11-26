@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="topbar">
        <div>
            <span class="page-kicker">Operations center</span>
            <h1>HospiBridge Dashboard</h1>
            <p class="page-subtitle">A live view of care activity, people, and incoming requests.</p>
        </div>
    </div>

    <div class="stats">
        <div class="stat-card">
            <div class="stat-card-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-card-title">Users</div>
                <div class="stat-card-value">{{ $usersCount }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon"><i class="fas fa-stethoscope"></i></div>
            <div>
                <div class="stat-card-title">Doctors</div>
                <div class="stat-card-value">{{ $doctorsCount }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon"><i class="fas fa-calendar-check"></i></div>
            <div>
                <div class="stat-card-title">Appointments</div>
                <div class="stat-card-value">{{ $appointmentsCount }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="stat-card-title">Pending</div>
                <div class="stat-card-value">{{ $pendingCount }}</div>
            </div>
        </div>
    </div>

    <div class="chart-container">
        <h3>Appointments Overview (last 14 days with activity)</h3>
        <canvas id="appointmentsChart"></canvas>
    </div>

    <div class="table-container dashboard-panel">
        <h3>Recent Appointments</h3>
        <table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Type</th>
                    <th>Reason</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->name }}</td>
                        <td>{{ ucfirst($appointment->appointment_type ?? 'normal') }}</td>
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
                            <small>{{ \Illuminate\Support\Str::limit($reason, 60) }}</small>
                        </td>
                        <td>{{ $appointment->doctor->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->schedule->date ?? 'N/A' }}</td>
                        <td>{{ $appointment->schedule->start_time ?? 'N/A' }}</td>
                        <td><span class="badge badge-{{ $appointment->status }}">{{ $appointment->status }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty-state">No appointments yet</td></tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-secondary">View all appointments</a>
    </div>

    <div class="table-container dashboard-panel" style="margin-top: 30px;">
        <h3>Recent Contact Messages</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->subject }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="empty-state">No messages yet</td></tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-secondary">View all messages</a>
    </div>

    <div class="table-container dashboard-panel" style="margin-top: 30px;">
        <h3>Recent Registrations</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentUsers as $recentUser)
                    <tr>
                        <td>{{ $recentUser->name }}</td>
                        <td>{{ $recentUser->email }}</td>
                        <td>{{ $recentUser->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="empty-state">No new registrations yet</td></tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">View all users</a>
    </div>
@endsection

@push('scripts')
<div id="appointmentsChartData"
     data-labels="{{ $chartLabels->implode(',') }}"
     data-values="{{ $chartValues->implode(',') }}"
     hidden></div>
<script>
    const ctx = document.getElementById('appointmentsChart');
    const chartDataEl = document.getElementById('appointmentsChartData');
    const chartLabels = (chartDataEl?.dataset.labels || '').split(',').filter(Boolean);
    const chartValues = (chartDataEl?.dataset.values || '')
        .split(',')
        .filter(Boolean)
        .map(value => Number(value));

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Appointments per Day',
                data: chartValues,
                backgroundColor: 'rgba(13, 71, 161, 0.6)',
                borderColor: 'rgba(13, 71, 161, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });
</script>
@endpush
