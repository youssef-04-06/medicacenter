@extends('admin.layout')

@section('title', 'Prescriptions')

@section('content')
    <div class="topbar">
        <div>
            <span class="page-kicker">Patient care</span>
            <h1>Prescriptions</h1>
            <p class="page-subtitle">Review patient requests, issue prescriptions, and manage downloadable records.</p>
        </div>
    </div>

    <div class="table-container appointments-panel">
        <table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Requested Doctor</th>
                    <th>Request</th>
                    <th>Status</th>
                    <th>Prescription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $requestItem)
                    <tr>
                        <td>
                            <strong>{{ $requestItem->name }}</strong><br>
                            <small>{{ $requestItem->email }}</small>
                            @if ($requestItem->phone)<br><small>{{ $requestItem->phone }}</small>@endif
                        </td>
                        <td>{{ $requestItem->doctor ? 'Dr. ' . $requestItem->doctor->name : 'Not selected' }}</td>
                        <td style="max-width:280px; white-space:pre-wrap;">{{ $requestItem->message ?: 'No request details provided.' }}</td>
                        <td><span class="badge badge-{{ $requestItem->status }}">{{ ucfirst($requestItem->status) }}</span></td>
                        <td>
                            @if ($requestItem->prescription)
                                <span style="color:#15803d; font-weight:700;">Issued</span>
                            @else
                                <span style="color:#b45309;">Awaiting review</span>
                            @endif
                        </td>
                        <td style="min-width:270px;">
                            <form action="{{ route('admin.prescriptions.store', $requestItem) }}" method="POST" style="border:1px solid #e2e8f0; border-radius:8px; padding:10px; margin-bottom:8px;">
                                @csrf
                                <input type="text" name="medication" class="status-select" style="display:block; width:100%; margin-bottom:8px;" placeholder="Medication" required>
                                <input type="text" name="dosage" class="status-select" style="display:block; width:100%; margin-bottom:8px;" placeholder="Dosage" required>
                                <textarea name="instructions" class="status-select" style="display:block; width:100%; margin-bottom:8px;" rows="3" placeholder="Instructions" required></textarea>
                                <button type="submit" class="btn btn-sm btn-success">{{ $requestItem->prescription ? 'Update Prescription' : 'Issue Prescription' }}</button>
                            </form>

                            @if ($requestItem->prescription)
                                <a href="{{ route('appointments.prescriptions.download', $requestItem) }}" class="btn btn-sm btn-secondary">Download PDF</a>
                            @endif
                            <form action="{{ route('admin.prescriptions.destroy', $requestItem) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this prescription request?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-state">No prescription requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $requests->links() }}</div>
    </div>
@endsection