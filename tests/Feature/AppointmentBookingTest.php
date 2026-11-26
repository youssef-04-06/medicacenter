<?php

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

test('chatbot bookings can create an appointment from doctor name and slot', function () {
    $doctor = Doctor::create([
        'name' => 'Dr. Sarah Johnson',
        'email' => 'sarah@example.com',
        'phone' => '0123456789',
        'specialty' => 'cardiology',
        'address' => 'Main Hospital',
    ]);

    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-07-12',
        'start_time' => '09:00:00',
        'end_time' => '10:00:00',
    ]);

    $response = postJson('/appointments', [
        'name' => 'AI Patient',
        'email' => 'ai@example.com',
        'doctor_name' => 'Dr. Sarah Johnson',
        'slot' => '9:00 AM',
        'message' => 'Booked via Quantum Health AI chatbot',
    ]);

    $response->assertOk()
        ->assertJson(['success' => true]);

    assertDatabaseHas('appointments', [
        'name' => 'AI Patient',
        'email' => 'ai@example.com',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'message' => 'Booked via Quantum Health AI chatbot',
    ]);
});

test('telemedicine bookings are stored as pending with structured details', function () {
    $doctor = Doctor::create([
        'name' => 'Dr. Rana',
        'email' => 'rana@example.com',
    ]);

    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-08-22',
        'start_time' => '14:00:00',
        'end_time' => '14:30:00',
    ]);

    $response = postJson('/appointments', [
        'name' => 'Tele Patient',
        'email' => 'tele@example.com',
        'phone' => '+96170000000',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'telemedicine',
        'location' => 'Beirut',
        'urgency' => 'medium',
        'symptoms' => 'Fever and cough',
        'message' => 'Telemedicine booking request',
    ]);

    $response->assertOk()->assertJson(['success' => true]);

    $appointment = Appointment::query()->where('email', 'tele@example.com')->first();

    expect($appointment)->not->toBeNull();
    expect($appointment->status)->toBe('pending');
    expect($appointment->appointment_type)->toBe('telemedicine');
    expect($appointment->appointment_details['location'] ?? null)->toBe('Beirut');
    expect($appointment->appointment_details['urgency'] ?? null)->toBe('medium');
    expect($appointment->appointment_details['symptoms'] ?? null)->toBe('Fever and cough');
});
