<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoomController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\StallController;
use App\Http\Controllers\VotingQuestionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ScoreTypeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
