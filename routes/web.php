<?php

use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;

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
})->middleware('guest');

Route::get('/dashboard', function () {

    $userId = Auth::id();
    $countries = Country::where('user_id', $userId)->get();

    return view('dashboard', compact("countries"));
})->middleware(['auth'])->name('dashboard');


Route::post('/countries', [CountryController::class, 'store'])->name('countries');
Route::put('/countries/{id}', [CountryController::class, 'update']);
Route::delete('/countries/{id}', [CountryController::class, 'destroy']);

require __DIR__ . '/auth.php';
