<?php

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Prescription;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('a doctor schedule slot cannot be booked by two patients', function () {
    $doctor = Doctor::create([
        'name' => 'Dr. Slot Guard',
        'email' => 'slot-guard@example.com',
    ]);

    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-10-10',
        'start_time' => '10:00:00',
        'end_time' => '10:30:00',
    ]);

    $firstPatient = User::factory()->create();
    $secondPatient = User::factory()->create();

    post(route('appointments.store'), [
        'name' => 'First Patient',
        'email' => 'first@example.com',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'normal',
    ])->assertOk();

    post(route('appointments.store'), [
        'name' => 'Second Patient',
        'email' => 'second@example.com',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'normal',
    ])->assertStatus(422)
        ->assertJsonPath('message', 'This time slot has already been booked.');

    expect(Appointment::where('schedule_id', $schedule->id)->count())->toBe(1);
});

test('patient can submit a prescription request from the services flow', function () {
    $patient = User::factory()->create();

    actingAs($patient);

    post(route('prescription-requests.store'), [
        'name' => $patient->name,
        'phone' => '+1234567890',
        'doctor_id' => Doctor::create(['name' => 'Dr. Request Target', 'email' => 'target@example.com'])->id,
        'message' => 'I need a refill for my regular medication.',
    ])
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('success');

    $request = Appointment::where('user_id', $patient->id)->latest()->first();

    expect($request)
        ->not->toBeNull()
        ->appointment_type->toBe('prescription')
        ->doctor_id->toBeInt()
        ->status->toBe('pending')
        ->message->toBe('I need a refill for my regular medication.');
});

test('admin can manage prescription requests from the prescriptions page', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $patient = User::factory()->create();

    $request = Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'appointment_type' => 'prescription',
        'message' => 'Please review my refill request.',
        'status' => 'pending',
    ]);

    actingAs($admin);

    get(route('admin.prescriptions.index'))
        ->assertOk()
        ->assertSee('Please review my refill request.');

    post(route('admin.prescriptions.store', $request), [
        'medication' => 'Paracetamol',
        'dosage' => '500mg',
        'instructions' => 'Take after meals.',
    ])->assertSessionHasNoErrors();

    expect($request->fresh()->status)->toBe('completed')
        ->and(Prescription::where('appointment_id', $request->id)->exists())->toBeTrue();
});

test('assigned doctor sees only targeted prescription requests', function () {
    $doctorUser = User::factory()->create(['role' => 'doctor']);
    $doctor = Doctor::create([
        'user_id' => $doctorUser->id,
        'name' => 'Dr. Targeted',
        'email' => $doctorUser->email,
    ]);
    $patient = User::factory()->create();

    Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'doctor_id' => $doctor->id,
        'appointment_type' => 'prescription',
        'message' => 'Targeted request',
        'status' => 'pending',
    ]);

    actingAs($doctorUser);

    get(route('doctor.dashboard'))
        ->assertOk()
        ->assertSee('Targeted request');
});

test('doctor or admin can save a prescription for an accepted appointment', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $patient = User::factory()->create();

    $doctor = Doctor::create([
        'name' => 'Dr. Kareem',
        'email' => 'kareem@example.com',
    ]);

    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-08-05',
        'start_time' => '09:00:00',
        'end_time' => '09:30:00',
    ]);

    $appointment = Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'phone' => '+1234567890',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'telemedicine',
        'status' => 'accepted',
    ]);

    actingAs($admin);

    post(route('appointments.prescriptions.store', $appointment), [
        'medication' => 'Paracetamol',
        'dosage' => '500mg',
        'instructions' => 'Take one tablet twice daily after meals.',
    ])->assertSessionHasNoErrors();

    expect(Prescription::where('appointment_id', $appointment->id)->exists())->toBeTrue();
});

test('assigned doctor can save a prescription that appears on the patient dashboard', function () {
    $doctorUser = User::factory()->create(['role' => 'doctor']);
    $patient = User::factory()->create();

    $doctor = Doctor::create([
        'user_id' => $doctorUser->id,
        'name' => 'Dr. Assigned',
        'email' => $doctorUser->email,
    ]);

    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-08-07',
        'start_time' => '10:00:00',
        'end_time' => '10:30:00',
    ]);

    $appointment = Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'normal',
        'status' => 'accepted',
    ]);

    actingAs($doctorUser);

    post(route('appointments.prescriptions.store', $appointment), [
        'medication' => 'Amoxicillin',
        'dosage' => '250mg',
        'instructions' => 'Take one capsule every eight hours.',
    ])->assertSessionHasNoErrors();

    expect(Prescription::where('appointment_id', $appointment->id)->value('patient_id'))->toBe($patient->id);

    actingAs($patient);

    get(route('dashboard'))
        ->assertOk()
        ->assertSee('Download PDF')
        ->assertSee(route('appointments.prescriptions.download', $appointment));
});

test('patient can download prescription pdf for own appointment', function () {
    $patient = User::factory()->create();

    $doctor = Doctor::create([
        'name' => 'Dr. Lina',
        'email' => 'lina@example.com',
    ]);

    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-08-06',
        'start_time' => '11:00:00',
        'end_time' => '11:30:00',
    ]);

    $appointment = Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'phone' => '+1234567890',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'telemedicine',
        'status' => 'completed',
    ]);

    Prescription::create([
        'appointment_id' => $appointment->id,
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'content' => "Medication: Paracetamol\nDosage: 500mg\nInstructions: Take after meals.",
    ]);

    actingAs($patient);

    $response = get(route('appointments.prescriptions.download', $appointment));

    $response->assertOk();
    $response->assertHeader('content-type', 'application/pdf');
});

test('admin can download a patient prescription pdf', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $patient = User::factory()->create();

    $appointment = Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'appointment_type' => 'prescription',
        'status' => 'pending',
    ]);

    Prescription::create([
        'appointment_id' => $appointment->id,
        'patient_id' => $patient->id,
        'content' => 'Medication: Refill\nDosage: As directed\nInstructions: Follow the care team instructions.',
    ]);

    actingAs($admin);

    get(route('appointments.prescriptions.download', $appointment))
        ->assertOk()
        ->assertHeader('content-type', 'application/pdf');
});
