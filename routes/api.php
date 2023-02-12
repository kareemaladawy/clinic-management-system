<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Patient\AuthController as PatientAuth;
use App\Http\Controllers\Auth\Doctor\AuthController as DoctorAuth;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SlotController;
use Symfony\Component\HttpKernel\Profiler\Profile;

/// public routes
// --- patient auth --- //
Route::post('/patient/register', [PatientAuth::class, 'register'])->name('patient.register');
Route::post('/patient/login', [PatientAuth::class, 'login'])->name('patient.login');


// --- doctor auth --- //
Route::post('/doctor/register', [DoctorAuth::class, 'register'])->name('doctor.register');
Route::post('/doctor/login', [DoctorAuth::class, 'login'])->name('doctor.login');


// diseases
Route::get('/diseases', [DiseaseController::class, 'index'])->name('diseases.get');
Route::post('/diseases', [DiseaseController::class, 'store'])->name('diseases.add');

// check
Route::post('/check', [IntegrateWithAIController::class, 'check'])->name('check');


/// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // --- auth actions --- //
    Route::post('/patient/logout', [PatientAuth::class, 'logout'])
        ->name('patient.logout');
    Route::post('/doctor/logout', [DoctorAuth::class, 'logout'])
        ->name('doctor.logout');


    // --- patient actions --- //
    // get a specific doctor profile
    Route::get('/doctors/{doctor}', [DoctorController::class, 'profile'])
        ->name('show-doctor-profile');

    // get popular doctor profiles
    Route::get('/doctors/search/popular', [DoctorController::class, 'popular'])
        ->name('doctors.popular');

    // get a specific doctor available slots
    Route::get('/doctors/{doctor}/availableslots', [DoctorController::class, 'availableslots'])
        ->name('doctor.get-available-slots');


    // appointments
    Route::apiresource('appointments', AppointmentController::class)
        ->only('index', 'store', 'show', 'destroy');

    // feedbacks
    Route::apiresource('feedbacks', FeedbackController::class)
        ->only('store', 'destroy');


    // --- doctor actions --- //
    Route::get('/doctor/slots', [SlotController::class, 'index'])
        ->name('doctor.slots');
    Route::post('/doctor/slots', [SlotController::class, 'store'])
        ->name('doctor.add-slot');


    // patient diagnosis
    Route::get('/doctor/patients/{patient}/diagnosis', [DiagnosisController::class, 'show'])
        ->name('doctor.get-patient-diagnosis');
    Route::post('/doctor/patients/{patient}/diagnosis', [DiagnosisController::class, 'store'])
        ->name('doctor.store-patient-diagnose');


    // profile
    Route::post('/profile/update', [ProfileController::class, 'update'])
        ->name('update-profile');
});
