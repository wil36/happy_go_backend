<?php

use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Kreait\Laravel\Firebase\Facades\Firebase;

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

// Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
//     return view('pages.chauffeur_nonvalide');
// })->name("commandes");

//User
Route::get('profile', [UserController::class, 'profile'])->name('user.profile');
Route::post('update_profile', [UserController::class, 'updateProfile'])->name('user.update.profile');
Route::post('update_password', [UserController::class, 'updatePassword'])->name('user.update.password');
Route::get('password', [UserController::class, 'changePassword'])->name('user.password');

//chauffeur
Route::middleware(['auth:sanctum', 'verified'])->get('/chauffeur-valides', [FirebaseController::class, 'getChauffeurValider'])->name("chauffeur.valide");
Route::middleware(['auth:sanctum', 'verified'])->get('/', [FirebaseController::class, 'getChauffeurNonValider'])->name("chauffeur.nonvalide");

Route::middleware(['auth:sanctum', 'verified'])->get('/changeTheme', function () {
    try {
        $user = User::find(Auth::user()->id);
        $user->theme = Auth::user()->theme == 0 ? 1 : 0;
        $user->save();
        return true;
    } catch (Exception $e) {
        return response()->json(["error" => "Une erreur s'est produite."]);
    }
})->name("theme");

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});