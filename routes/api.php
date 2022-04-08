<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilletController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\FoundAndLostController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WallController;
use App\Http\Controllers\WarningController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function(){
    return ['ping' => true];
});

Route::get('/401', [AuthController::class, 'aunathorized'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function(){

    Route::post('/auth/validate', [AuthController::class, 'validateToken']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    //Mural de avisos
    Route::get('/walls', [WallController::class, 'getAll']);
    Route::post('/wall/{id}/like', [WallController::class, 'like']);

    //Documentos
    Route::get('/docs', [DocController::class, 'getAll']);

    //Livro de Ocorrências
    Route::get('/warnings', [WarningController::class, 'getMyWarning']);
    Route::get('/warning', [WarningController::class, 'setWarning']);
    Route::get('/warning/file', [WarningController::class, 'addWarningFile']);

    // Bolletos
    Route::get('/billets',[BilletController::class, 'getAll']);
    
    //Achados e Perdidos
    Route::post('/foundandlost',[FoundAndLostController::class,'insert']);
    Route::get('/foundandlost',[FoundAndLostController::class, 'getAll']);
    Route::put('/foundandlost/{id}', [FoundAndLostController::class ,'update']);

    // Unidade
    Route::get('/unit/{id}',[UnitController::class, 'getInfoo']);
    Route::post('/unit/{id}/addperson',[UnitController::class, 'addperson']);
    Route::post('/unit/{id}/addpet',[UnitController::class, 'addpet']);
    Route::delete('/unit/{id}/removeperson',[UnitController::class, 'removeperson']);
    Route::get('/unit/{id}/removepet',[UnitController::class, 'removepet']);

    //Reservas
    Route::get('/reservations', [ReservationController::class, 'getResevation']);
    Route::post('/resevation/{id}', [ReservationController::class, 'setResevations']);

    Route::get('/resavation/{id}/disableddates', [ReservationController::class, 'getDisableddates']);
    Route::get('/resavation/{id}/times', [ReservationController::class, 'getTimes']);

    Route::get('/myresevations/{id}', [ReservationController::class, 'getMyresevations']);
    Route::delete('/myresevations/{id}', [ReservationController::class, 'deleteMyresevations']);
    
    

});