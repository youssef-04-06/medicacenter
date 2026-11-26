@extends('layouts.app')
@section('content')
<div class="container mt-5">
   <h1 class="text-center mb-4 fw-bold text-primary">About Our Medical Reservation System</h1>
    <p class="text-center text-muted mb-5" style="max-width: 700px; margin:auto;">
            Our platform is a smart medical reservation system designed to improve healthcare access across Lebanon. 
    It allows patients to book appointments easily, receive intelligent doctor recommendations, and manage 
    their medical visits in a fast and efficient way.
    </p>
</div>
  <div class="row text-center">

    <div class="col-md-4 mb-4">
        <div class="card p-4 shadow border-0 rounded-4 h-100">
            <h5 class="text-center mb-4 fw-bold">Our Mission</h5>
            <p class="text-muted">
                To simplify the medical appointment process by reducing waiting times, guiding patients to the right doctors,
                and improving coordination between patients and healthcare providers.
            </p>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card p-4 shadow border-0 rounded-4 h-100">
            <h5 class="text-center mb-4 fw-bold">Our Vision</h5>
            <p class="text-muted">
                To become a leading smart healthcare platform that combines technology and medical services
                to improve accessibility, efficiency, and patient care across Lebanon.
            </p>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card p-4 shadow border-0 rounded-4 h-100">
            <h5 class="text-center mb-4 fw-bold">Our Values</h5>
            <p class="text-muted">
                We focus on innovation, care, and reliability, ensuring every patient receives accurate guidance
                and a better healthcare experience.
            </p>
        </div>
    </div>

</div>  

<div class="mt-5">
    <h3 class="text-center mb-4 fw-bold">Smart Features</h3>
    <div class="row text-center">
        <div class="col-md-3 mb-4">
            <div class="card p-3 border-0 shadow-sm rounded-4 h-100">
                <p>AI-based symptom analysis to guide patients to the right doctor.</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card p-3 border-0 shadow-sm rounded-4 h-100">
                <p>Real-time doctor availability and smart appointment scheduling.</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card p-3 border-0 shadow-sm rounded-4 h-100">
                <p>Notifications and reminders to help patients manage appointments.</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card p-3 border-0 shadow-sm rounded-4 h-100">
                <p>Family management system for booking appointments for multiple members.</p>
            </div>
        </div>

    </div>

</div>
<div class="heartbeat-footer mt-5">
    <div class="heartbeat-side">
        <svg viewBox="0 0 300 60" class="heartbeat-svg" preserveAspectRatio="none">
            <path d="M0 30 H70 L90 30 L105 10 L120 50 L140 30 H300" />
        </svg>
    </div>

    <div class="heartbeat-center">
        HospiBridge • @2026
    </div>

    <div class="heartbeat-side">
        <svg viewBox="0 0 300 60" class="heartbeat-svg" preserveAspectRatio="none">
            <path d="M0 30 H70 L90 30 L105 10 L120 50 L140 30 H300" />
        </svg>
    </div>
</div>



@endsection