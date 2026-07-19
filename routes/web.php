<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// === PAGES PUBLIQUES ===
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/chambres', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/chambres/{slug}', [RoomController::class, 'show'])->name('rooms.show');

// Tunnel de réservation
Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation.index');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/reservation/{ref}/confirmation', [ReservationController::class, 'confirmation'])->name('reservation.confirmation');
Route::get('/reservation/annuler/{token}', [ReservationController::class, 'cancel'])->name('reservation.cancel');

// Retrouver sa réservation (référence + email, limité contre l'énumération)
Route::get('/ma-reservation', [ReservationController::class, 'lookupForm'])->name('reservation.lookup');
Route::post('/ma-reservation', [ReservationController::class, 'lookup'])
    ->middleware('throttle:10,1')
    ->name('reservation.lookup.submit');

// Pages statiques
Route::get('/a-propos', function () {
    $rooms = \App\Models\Room::where('status', 'active')->orderBy('price_per_night')->get();
    return view('about', compact('rooms'));
})->name('about');
Route::view('/mentions-legales', 'legal')->name('legal');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// === AUTHENTIFICATION ADMIN ===
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// === BACK-OFFICE (protégé) ===
Route::prefix('admin')->name('admin.')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/nouvelle', [AdminReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [AdminReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');
    Route::patch('/reservations/{reservation}', [AdminReservationController::class, 'update'])->name('reservations.update');

    Route::get('/chambres', [AdminRoomController::class, 'index'])->name('rooms.index');
    Route::get('/chambres/nouvelle', [AdminRoomController::class, 'create'])->name('rooms.create');
    Route::post('/chambres', [AdminRoomController::class, 'store'])->name('rooms.store');
    Route::get('/chambres/{room}/modifier', [AdminRoomController::class, 'edit'])->name('rooms.edit');
    Route::patch('/chambres/{room}', [AdminRoomController::class, 'update'])->name('rooms.update');
    Route::delete('/chambres/{room}', [AdminRoomController::class, 'destroy'])->name('rooms.destroy');

    Route::get('/tarifs', [PricingController::class, 'index'])->name('pricing.index');
    Route::post('/tarifs', [PricingController::class, 'store'])->name('pricing.store');
    Route::delete('/tarifs/{pricingRule}', [PricingController::class, 'destroy'])->name('pricing.destroy');
    Route::patch('/tarifs/{pricingRule}/toggle', [PricingController::class, 'toggle'])->name('pricing.toggle');
});
