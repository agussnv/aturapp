<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\PasswordResetController;

    Route::get('/', function () {
        return view('welcome');
    });

    //====== VERIFICAR EMAIL ======================
    Route::get('/verify-email/{token}', [UserController::class, 'verifyEmail'])->name('verify.email');


    //====== RESTABLECER PASSWORD =================
    Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');

    Route::post('/password/reset', [PasswordResetController::class, 'reset']);


    //====== RESTABLECER PASSWORD =================
    Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');

    Route::post('/password/reset', [PasswordResetController::class, 'reset']);