@extends('admin.layout')

@section('title', 'Doctors')

@section('content')
    <div class="topbar">
        <div>
            <span class="page-kicker">Care team</span>
            <h1>Doctors</h1>
            <p class="page-subtitle">Manage clinician profiles, schedules, and appointment workload.</p>
        </div>
        <a href="{{ route('admin.doctors.create') }}" class="btn"><i class="fas fa-user-plus"></i> Add Doctor</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Specialty</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Time Slots</th>
                    <th>Appointments</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($doctors as $doctor)
                    <tr>
                        <td>{{ $doctor->name }}</td>
                        <td>{{ $doctor->specialty ?? '—' }}</td>
                        <td>{{ $doctor->email ?? '—' }}</td>
                        <td>{{ $doctor->phone ?? '—' }}</td>
                        <td>{{ $doctor->schedules_count }}</td>
                        <td>{{ $doctor->appointments_count }}</td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.doctors.schedules.index', $doctor) }}" class="btn btn-sm btn-secondary">Schedule</a>
                            <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-sm">Edit</a>
                            <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" onsubmit="return confirm('Delete this doctor? This also removes their schedules and appointments.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty-state">No doctors added yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
