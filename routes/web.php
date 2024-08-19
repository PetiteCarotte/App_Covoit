<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/vosTrajets', [TrajetController::class, 'vosTrajets'])->name('trajets.vosTrajets');




Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Utilisateurs
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

    // Recherche de trajets
    Route::get('/dashboard', [TrajetController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/search', [TrajetController::class, 'search'])->name('dashboard.search');

    // Trajets
    Route::resource('/trajets', TrajetController::class);

    Route::get('/trajets/{trajet}/edit', [TrajetController::class, 'edit'])->name('trajets.edit');

    // Réservation d'un trajet
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    //Annulation d'une réservation
    Route::post('/reservations/cancel/{id_passager}/{id_trajet}', [ReservationController::class, 'cancel'])->name('reservations.cancel');

    //Accepter une reservation 
    Route::post('/reservations/{id_passager}/{id_trajet}/accept', [TrajetController::class, 'accept'])->name('reservations.accept');
    //Refuser une reservation
    Route::post('/reservations/{id_passager}/{id_trajet}/refuse', [TrajetController::class, 'refuse'])->name('reservations.refuse');
    //Retirer une reservation
    Route::post('/reservations/{id_passager}/{id_trajet}/remove', [TrajetController::class, 'remove'])->name('reservations.remove');


    // Suppression d'un trajet
    Route::post('/trajets/delete/{id}', [TrajetController::class, 'delete'])->name('trajets.delete');

    Route::get('/communes', 'App\Http\Controllers\CommuneController@search')->name('communes.search');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');

    Route::delete('/messages/{index}', [MessageController::class, 'destroy'])->name('messages.destroy');

});


Route::get('/communes/{code_postal}', [RegisteredUserController::class, 'getCommunesByPostalCode']);


require __DIR__ . '/auth.php';
