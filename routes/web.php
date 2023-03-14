<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\StyleController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SongsUsersController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\TestController;

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

Route::middleware('guest')->group(function(){
    Route::get('/', [HomeController::class, 'show'])->name('landing');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/disconnect', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::get('/artist', [ArtistController::class, 'index'])->name('artist.index');
    Route::get('/artist/{slug}', [ArtistController::class, 'show'])->name('artist.show');

    Route::post('/album', [SongsUsersController::class, 'store'])->name('album.store');
    Route::get('/album/{slug}', [AlbumController::class, 'show'])->name('album.show');

    // Route::get('/song/{slug}', [SongController::class, 'show'])->name('song.show');

    Route::get('/style', [StyleController::class, 'index'])->name('style.index');
    Route::get('/style/{slug}', [StyleController::class, 'show'])->name('style.show');

    Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::post('/favorite', [SongController::class, 'listenPlaylist'])->name('favorite.play');

    Route::get('/test', [TestController::class, 'index'])->name('test.index');
    Route::get('/test2', [TestController::class, 'show'])->name('test.show');

});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';
