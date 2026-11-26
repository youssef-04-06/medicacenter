<?php

use Illuminate\Support\Facades\Route;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\DoctorScheduleController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PrescriptionController as AdminPrescriptionController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\PatientMessageController;
use App\Http\Controllers\PatientPaymentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PatientMessageController as AdminPatientMessageController;
use App\Http\Controllers\Doctor\PaymentController as DoctorPaymentController;
use App\Http\Controllers\Doctor\PatientMessageController as DoctorPatientMessageController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    try {
        $chatbotDoctors = Doctor::query()
            ->select(['id', 'name', 'specialty'])
            ->with(['schedules' => function ($query) {
                $query->select(['id', 'doctor_id', 'date', 'start_time', 'end_time'])
                    ->whereDate('date', '>=', today())
                    ->orderBy('date')
                    ->orderBy('start_time');
            }])
            ->get();
    } catch (\Throwable $e) {
        $chatbotDoctors = collect();
    }

    return view('index', compact('chatbotDoctors'));
})->name('home');
Route::view('/about', 'about')->name('about');
Route::get('/services', function () {
    try {
        $bookingDoctors = Doctor::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();
    } catch (\Throwable $e) {
        $bookingDoctors = collect();
    }

    return view('services', compact('bookingDoctors'));
})->name('services');
Route::view('/contactz', 'contactz')->name('contact');
Route::view('/awareness', 'awareness')->name('awareness');
Route::view('/health', 'health')->name('health');
Route::view('/healthcare', 'healthcare')->name('healthcare');
Route::view('/e-services', 'e-services')->name('e-services');

/*
|--------------------------------------------------------------------------
| FORM ROUTES
|--------------------------------------------------------------------------
*/
Route::post('/appointments', [AppointmentController::class, 'store'])
    ->name('appointments.store');

Route::post('/contactz', [ContactController::class, 'store'])
    ->name('contact.store');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/my-appointments', [UserDashboardController::class, 'myAppointments'])
    ->middleware('auth')
    ->name('my-appointments');

Route::get('/prescriptions', [UserDashboardController::class, 'prescriptions'])
    ->middleware('auth')
    ->name('prescriptions');

Route::get('/payments', [PatientPaymentController::class, 'index'])->middleware('auth')->name('payments');
Route::get('/messages', [PatientMessageController::class, 'index'])->middleware('auth')->name('messages');
Route::post('/messages', [PatientMessageController::class, 'store'])->middleware('auth')->name('messages.store');

Route::middleware('auth')->group(function () {
    Route::post('/prescription-requests', [PrescriptionController::class, 'request'])
        ->name('prescription-requests.store');

    Route::get('/appointments/{appointment}/prescription/download', [PrescriptionController::class, 'download'])
        ->name('appointments.prescriptions.download');

    Route::post('/appointments/{appointment}/prescriptions', [PrescriptionController::class, 'store'])
        ->name('appointments.prescriptions.store');
});

/*
|--------------------------------------------------------------------------
| DOCTOR PORTAL (auth + doctor role, guarded by doctors.user_id link)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/', [DoctorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [DoctorDashboardController::class, 'appointments'])->name('appointments');
    Route::get('/prescriptions', [DoctorDashboardController::class, 'prescriptions'])->name('prescriptions');
    Route::get('/payments', [DoctorPaymentController::class, 'index'])->name('payments');
    Route::get('/messages', [DoctorPatientMessageController::class, 'index'])->name('messages');
    Route::post('/messages/{message}/reply', [DoctorPatientMessageController::class, 'reply'])->name('messages.reply');
});

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD (real auth: users.is_admin, guarded by auth + admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('doctors', DoctorController::class)->except(['show']);

    Route::get('doctors/{doctor}/schedules', [DoctorScheduleController::class, 'index'])
        ->name('doctors.schedules.index');
    Route::get('doctors/{doctor}/schedules/create', [DoctorScheduleController::class, 'create'])
        ->name('doctors.schedules.create');
    Route::post('doctors/{doctor}/schedules', [DoctorScheduleController::class, 'store'])
        ->name('doctors.schedules.store');
    Route::delete('doctors/{doctor}/schedules/{schedule}', [DoctorScheduleController::class, 'destroy'])
        ->name('doctors.schedules.destroy');

    Route::get('appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::patch('appointments/{appointment}', [AdminAppointmentController::class, 'update'])->name('appointments.update');
    Route::post('appointments/{appointment}/accept', [AdminAppointmentController::class, 'accept'])->name('appointments.accept');
    Route::post('appointments/{appointment}/reject', [AdminAppointmentController::class, 'reject'])->name('appointments.reject');
    Route::post('appointments/{appointment}/accept-notify', [AdminAppointmentController::class, 'acceptAndNotify'])
        ->name('appointments.accept-notify');
    Route::get('appointments/{appointment}/whatsapp', [AdminAppointmentController::class, 'whatsappLink'])->name('appointments.whatsapp');
    Route::delete('appointments/{appointment}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');

    Route::get('prescriptions', [AdminPrescriptionController::class, 'index'])->name('prescriptions.index');
    Route::post('prescriptions/{appointment}', [AdminPrescriptionController::class, 'store'])->name('prescriptions.store');
    Route::delete('prescriptions/{appointment}', [AdminPrescriptionController::class, 'destroy'])->name('prescriptions.destroy');

    Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::patch('payments/{payment}', [AdminPaymentController::class, 'update'])->name('payments.update');
    Route::get('patient-messages', [AdminPatientMessageController::class, 'index'])->name('patient-messages.index');
    Route::post('patient-messages/{message}/reply', [AdminPatientMessageController::class, 'reply'])->name('patient-messages.reply');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('messages/{contact}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::delete('messages/{contact}', [MessageController::class, 'destroy'])->name('messages.destroy');
});

/*
|--------------------------------------------------------------------------
| AJAX / DATA ROUTES (used by the public booking widget)
|--------------------------------------------------------------------------
*/

// Doctors list
Route::get('/doctors', function () {
    try {
        return response()->json(
            Doctor::query()->select(['id', 'name'])->orderBy('name')->get()
        );
    } catch (\Throwable $e) {
        return response()->json([]);
    }
});

// Doctor dates
Route::get('/doctor/{id}/dates', function ($id) {
    return DoctorSchedule::where('doctor_id', $id)
        ->whereDate('date', '>=', today())
        ->pluck('date')
        ->unique()
        ->values();
});

// Doctor times
Route::get('/doctor/{id}/dates/{date}/times', function ($id, $date) {
    $query = DoctorSchedule::where('doctor_id', $id)
        ->where('date', $date);

    if ($date === today()->toDateString()) {
        $query->where('start_time', '>=', now()->format('H:i:s'));
    }

    return $query->get(['id', 'start_time', 'end_time']);
});
