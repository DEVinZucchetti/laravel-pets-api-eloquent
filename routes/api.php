<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\PeoplesController;
use App\Http\Controllers\SpecieController;
use Illuminate\Support\Facades\Route;

Route::resource('peoples', PeoplesController::class)->only(
  ['index', 'show', 'store', 'update', 'destroy']
);

Route::resource('pets', PetController::class)->only(
  ['index', 'show', 'store', 'update', 'destroy']
);

Route::prefix('races')->group(function () {
  Route::get('', [RaceController::class, 'index']);
  Route::post('', [RaceController::class, 'store']);
});

Route::get('species', [SpecieController::class, 'index']);
Route::post('species', [SpecieControllerontroller::class, 'store']);
Route::get('species/{id}', [SpecieControllerontroller::class, 'show']);
Route::delete('species/{id}', [SpecieControllerontroller::class, 'destroy']);
Route::put('species/{id}', [SpecieControllerontroller::class, 'update']);

