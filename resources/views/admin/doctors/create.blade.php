@extends('admin.layout')

@section('title', 'Add Doctor')

@section('content')
    <div class="topbar">
        <h1>Add Doctor</h1>
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.doctors.store') }}">
            @csrf
            @include('admin.doctors._form')
            <button type="submit" class="btn">Save Doctor</button>
        </form>
    </div>
@endsection
