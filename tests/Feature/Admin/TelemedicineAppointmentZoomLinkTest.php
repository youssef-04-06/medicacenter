<?php

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Prescription;
use App\Models\User;
use App\Services\WhatsAppService;
use App\Services\ZoomService;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('telemedicine appointment acceptance creates zoom links and marks status accepted', function () {
    config()->set('services.zoom.account_id', 'test-account');
    config()->set('services.zoom.client_id', 'test-client');
    config()->set('services.zoom.client_secret', 'test-secret');
    config()->set('services.whatsapp.token', 'test-token');
    config()->set('services.whatsapp.phone_number_id', 'test-phone-number-id');

    $admin = User::factory()->create(['is_admin' => true]);
    $patient = User::factory()->create();
    $doctor = Doctor::create([
        'name' => 'Dr. Sami',
        'email' => 'sami@example.com',
    ]);
    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-08-01',
        'start_time' => '10:00:00',
        'end_time' => '10:30:00',
    ]);
    $appointment = Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'phone' => '12345678',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'telemedicine',
        'appointment_details' => ['symptoms' => 'Fever'],
        'message' => 'Appointment Type: Telemedicine | Symptoms: Fever',
        'status' => 'pending',
    ]);

    $zoom = Mockery::mock(ZoomService::class);
    $zoom->shouldReceive('createMeeting')
        ->once()
        ->andReturn([
            'join_url' => 'https://zoom.us/j/123456789',
            'start_url' => 'https://zoom.us/s/123456789?zak=abc',
            'meeting_id' => '123456789',
        ]);
    app()->instance(ZoomService::class, $zoom);

    $whatsApp = Mockery::mock(WhatsAppService::class);
    $whatsApp->shouldReceive('sendAppointmentLink')->once()->andReturn(true);
    app()->instance(WhatsAppService::class, $whatsApp);

    actingAs($admin);

    $response = post(route('admin.appointments.accept', $appointment), [
        'duration' => 30,
    ]);

    $response->assertSessionHasNoErrors();

    $appointment->refresh();

    expect($appointment->status)->toBe('accepted');
    expect($appointment->zoom_join_url)->toBe('https://zoom.us/j/123456789');
    expect($appointment->zoom_start_url)->toBe('https://zoom.us/s/123456789?zak=abc');
    expect($appointment->zoom_meeting_id)->toBe('123456789');
});

test('accepted telemedicine appointments show the zoom join link on the patient dashboard', function () {
    config()->set('services.zoom.account_id', 'test-account');
    config()->set('services.zoom.client_id', 'test-client');
    config()->set('services.zoom.client_secret', 'test-secret');
    config()->set('services.whatsapp.token', 'test-token');
    config()->set('services.whatsapp.phone_number_id', 'test-phone-number-id');

    $admin = User::factory()->create(['is_admin' => true]);
    $patient = User::factory()->create();
    $doctor = Doctor::create([
        'name' => 'Dr. Rana',
        'email' => 'rana@example.com',
    ]);
    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-08-02',
        'start_time' => '14:00:00',
        'end_time' => '14:30:00',
    ]);
    $appointment = Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'phone' => '12345678',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'telemedicine',
        'appointment_details' => ['symptoms' => 'Headache'],
        'message' => 'Appointment Type: Telemedicine | Symptoms: Headache',
        'status' => 'pending',
    ]);
    $zoomLink = 'https://zoom.us/j/123456789';

    $zoom = Mockery::mock(ZoomService::class);
    $zoom->shouldReceive('createMeeting')
        ->once()
        ->andReturn([
            'join_url' => $zoomLink,
            'start_url' => 'https://zoom.us/s/123456789?zak=abc',
            'meeting_id' => '123456789',
        ]);
    app()->instance(ZoomService::class, $zoom);

    $whatsApp = Mockery::mock(WhatsAppService::class);
    $whatsApp->shouldReceive('sendAppointmentLink')->once()->andReturn(true);
    app()->instance(WhatsAppService::class, $whatsApp);

    actingAs($admin);

    post(route('admin.appointments.accept', $appointment), [
        'duration' => 30,
    ])->assertSessionHasNoErrors();

    $appointment->refresh();

    expect($appointment->status)->toBe('accepted');
    expect($appointment->zoom_join_url)->toBe($zoomLink);

    actingAs($patient);

    get(route('dashboard'))
        ->assertOk()
        ->assertSee('Join Zoom Meeting')
        ->assertSee($zoomLink);
});

test('admin can reject a pending appointment and clear zoom data', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $doctor = Doctor::create([
        'name' => 'Dr. Nader',
        'email' => 'nader@example.com',
    ]);
    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-08-03',
        'start_time' => '11:00:00',
        'end_time' => '11:30:00',
    ]);
    $appointment = Appointment::create([
        'name' => 'Pending Patient',
        'email' => 'pending@example.com',
        'phone' => '12345678',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'telemedicine',
        'status' => 'pending',
        'zoom_join_url' => 'https://zoom.us/j/123',
        'zoom_start_url' => 'https://zoom.us/s/123',
        'zoom_meeting_id' => '123',
    ]);

    actingAs($admin);

    post(route('admin.appointments.reject', $appointment))
        ->assertSessionHasNoErrors();

    $appointment->refresh();

    expect($appointment->status)->toBe('rejected');
    expect($appointment->zoom_join_url)->toBeNull();
    expect($appointment->zoom_start_url)->toBeNull();
    expect($appointment->zoom_meeting_id)->toBeNull();
});

test('patient can download prescription as pdf for their appointment', function () {
    $patient = User::factory()->create();
    $doctor = Doctor::create([
        'name' => 'Dr. Hala',
        'email' => 'hala@example.com',
    ]);
    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-08-04',
        'start_time' => '15:00:00',
        'end_time' => '15:30:00',
    ]);
    $appointment = Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'phone' => '12345678',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'telemedicine',
        'status' => 'completed',
    ]);

    Prescription::create([
        'appointment_id' => $appointment->id,
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'content' => "Medication: Paracetamol\nDosage: 500mg\nInstructions: Twice daily",
    ]);

    actingAs($patient);

    get(route('appointments.prescriptions.download', $appointment))
        ->assertOk()
        ->assertHeader('content-type', 'application/pdf');
});

test('telemedicine appointment can still be accepted when zoom credentials are missing', function () {
    config()->set('services.zoom.account_id', null);
    config()->set('services.zoom.client_id', null);
    config()->set('services.zoom.client_secret', null);
    config()->set('services.whatsapp.token', 'test-token');
    config()->set('services.whatsapp.phone_number_id', 'test-phone-number-id');

    $admin = User::factory()->create(['is_admin' => true]);
    $patient = User::factory()->create();
    $doctor = Doctor::create([
        'name' => 'Dr. Mira',
        'email' => 'mira@example.com',
    ]);
    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-08-05',
        'start_time' => '13:00:00',
        'end_time' => '13:30:00',
    ]);
    $appointment = Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'phone' => '12345678',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'telemedicine',
        'status' => 'pending',
    ]);

    $zoom = Mockery::mock(ZoomService::class);
    $zoom->shouldNotReceive('createMeeting');
    app()->instance(ZoomService::class, $zoom);

    $whatsApp = Mockery::mock(WhatsAppService::class);
    $whatsApp->shouldReceive('sendAppointmentLink')->once()->andReturn(true);
    app()->instance(WhatsAppService::class, $whatsApp);

    actingAs($admin);

    post(route('admin.appointments.accept', $appointment), [
        'duration' => 30,
    ])->assertSessionHasNoErrors();

    $appointment->refresh();

    expect($appointment->status)->toBe('accepted');
    expect($appointment->zoom_join_url)->toBeNull();
    expect($appointment->zoom_start_url)->toBeNull();
    expect($appointment->zoom_meeting_id)->toBeNull();
});

test('telemedicine appointment can still be accepted when whatsapp credentials are missing', function () {
    config()->set('services.zoom.account_id', 'test-account');
    config()->set('services.zoom.client_id', 'test-client');
    config()->set('services.zoom.client_secret', 'test-secret');
    config()->set('services.whatsapp.token', null);
    config()->set('services.whatsapp.phone_number_id', null);

    $admin = User::factory()->create(['is_admin' => true]);
    $patient = User::factory()->create();
    $doctor = Doctor::create([
        'name' => 'Dr. Twilio Missing',
        'email' => 'twilio-missing@example.com',
    ]);
    $schedule = DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'date' => '2026-08-06',
        'start_time' => '16:00:00',
        'end_time' => '16:30:00',
    ]);
    $appointment = Appointment::create([
        'user_id' => $patient->id,
        'name' => $patient->name,
        'email' => $patient->email,
        'phone' => '12345678',
        'doctor_id' => $doctor->id,
        'schedule_id' => $schedule->id,
        'appointment_type' => 'telemedicine',
        'status' => 'pending',
    ]);

    $zoom = Mockery::mock(ZoomService::class);
    $zoom->shouldReceive('createMeeting')
        ->once()
        ->andReturn([
            'join_url' => 'https://zoom.us/j/987654321',
            'start_url' => 'https://zoom.us/s/987654321?zak=abc',
            'meeting_id' => '987654321',
        ]);
    app()->instance(ZoomService::class, $zoom);

    $whatsApp = Mockery::mock(WhatsAppService::class);
    $whatsApp->shouldNotReceive('sendAppointmentLink');
    app()->instance(WhatsAppService::class, $whatsApp);

    actingAs($admin);

    post(route('admin.appointments.accept', $appointment), [
        'duration' => 30,
    ])->assertSessionHasNoErrors();

    $appointment->refresh();

    expect($appointment->status)->toBe('accepted');
    expect($appointment->zoom_join_url)->toBe('https://zoom.us/j/987654321');
});