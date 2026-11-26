@extends('admin.layout')

@section('title', 'Edit Doctor')

@section('content')
    <div class="topbar">
        <h1>Edit Doctor</h1>
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.doctors.update', $doctor) }}">
            @csrf
            @method('PUT')
            @include('admin.doctors._form')
            <button type="submit" class="btn">Update Doctor</button>
        </form>
    </div>
@endsection
