<?php


use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\TicketController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::group(['middleware' => ['auth','verified'],
              'as' => 'dashboard.',
               'prefix' => 'dashboard'], function () {




    #### Dashboard ####
    Route::get('/', [DashboardController::class, 'index']);



    ### Tickets
    Route::resource('tickets', TicketController::class);
});
