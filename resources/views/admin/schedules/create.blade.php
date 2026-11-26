@extends('admin.layout')

@section('title', 'Add Time Slot')

@section('content')
    <div class="topbar">
        <h1>Add Time Slot for {{ $doctor->name }}</h1>
        <a href="{{ route('admin.doctors.schedules.index', $doctor) }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.doctors.schedules.store', $doctor) }}">
            @csrf

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" value="{{ old('date') }}" required>
                @error('date') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                @error('start_time') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                @error('end_time') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn">Save Time Slot</button>
        </form>
    </div>
@endsection
