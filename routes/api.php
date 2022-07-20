<?php

use App\Http\Controllers\AdminAppointmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/Route::post('signup', [AuthController::class, 'PatientSignUp']);
Route::post('login' ,[AuthController::class,'Login']);
Route::middleware(['auth:sanctum','role:Admin'])->group(function () {
    Route::resource('doctors', DoctorController::class)
        ->only('index', 'store', 'destroy', 'show'); // ShowAll / Store / Destroy / Show one
    Route::post('doctors/{user}', [DoctorController::class, 'update']); // Use Post for getting image with form data
    Route::get('doctorsheet/{user}', [AdminAppointmentController::class,'GetDoctorSheet']);
    Route::post('admin/appointments/{user}', [AdminAppointmentController::class,'storeAppointment']);
    Route::delete('appointments/{appointment}', [AdminAppointmentController::class,'destroy']);
    Route::patch('appointments/{appointment}', [AdminAppointmentController::class,'update']);


});
Route::middleware(['auth:sanctum','role:Patient'])->group(function () {
    Route::get('appointments', [AppointmentController::class,'index']);
    Route::post('appointments/{user}', [AppointmentController::class,'store']);

});
