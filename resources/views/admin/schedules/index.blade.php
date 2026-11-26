@extends('admin.layout')

@section('title', 'Schedule · ' . $doctor->name)

@section('content')
    <div class="topbar">
        <h1>{{ $doctor->name }}'s Schedule</h1>
        <div class="actions-cell">
            <a href="{{ route('admin.doctors.schedules.create', $doctor) }}" class="btn">+ Add Time Slot</a>
            <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Back to Doctors</a>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->date }}</td>
                        <td>{{ $schedule->start_time }}</td>
                        <td>{{ $schedule->end_time }}</td>
                        <td>
                            <form action="{{ route('admin.doctors.schedules.destroy', [$doctor, $schedule]) }}" method="POST" onsubmit="return confirm('Remove this time slot?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty-state">No time slots added yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
