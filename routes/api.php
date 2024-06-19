<?php

use App\Http\Controllers\TournamentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/newTournament', [TournamentController::class, 'createTournament'])->name('create.tournament');
Route::post('/newRound/{tournament}', [TournamentController::class, 'newRound'])->name('create.round');
