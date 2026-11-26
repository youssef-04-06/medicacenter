<?php

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\PatientMessage;
use App\Models\Payment;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\patch;

 test('patient can message admin and see the reply', function () {
    $patient = User::factory()->create();
    $admin = User::factory()->create(['is_admin' => true]);

    actingAs($patient);
    post(route('messages.store'), [
        'recipient_type' => 'admin',
        'subject' => 'Question',
        'message' => 'Can you help me?',
    ])->assertSessionHasNoErrors();

    $message = PatientMessage::firstOrFail();

    actingAs($admin);
    post(route('admin.patient-messages.reply', $message), ['reply' => 'Yes, we can help.'])
        ->assertSessionHasNoErrors();

    actingAs($patient);
    get(route('messages'))->assertOk()->assertSee('Yes, we can help.');
});

test('doctor sees assigned payment and can reply to targeted patient message', function () {
    $doctorUser = User::factory()->create(['role' => 'doctor']);
    $doctor = Doctor::create(['user_id' => $doctorUser->id, 'name' => 'Dr. Portal', 'email' => $doctorUser->email]);
    $patient = User::factory()->create();
    $appointment = Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'doctor_id' => $doctor->id,
        'appointment_type' => 'telemedicine',
        'status' => 'pending',
    ]);
    Payment::create([
        'appointment_id' => $appointment->id,
        'user_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'amount' => 20,
        'payment_method' => 'whish',
        'reference' => 'WH-123',
    ]);
    $message = PatientMessage::create([
        'user_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'recipient_type' => 'doctor',
        'message' => 'Please call me.',
    ]);

    actingAs($doctorUser);
    get(route('doctor.payments'))->assertOk()->assertSee('WH-123');
    post(route('doctor.messages.reply', $message), ['reply' => 'I will call you shortly.'])
        ->assertSessionHasNoErrors();

    expect($message->fresh()->reply)->toBe('I will call you shortly.');
});
