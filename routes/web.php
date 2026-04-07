<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Game;
use App\Models\Riddle;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RiddleController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InquiryController;
use Illuminate\Http\Request;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()], // по email ищет
        [                                       // если не найдет, поэтим данным создает
            'name' => $googleUser->getName(),
            'password' => bcrypt(str()->random(32)),
        ]
    );

    Auth::login($user);

    return redirect('/dashboard');
});

Route::controller(RiddleController::class)->group(function () {
    Route::get('/riddles/all', 'index')->name('riddles.index');
    Route::get('/riddles/create', 'create')->name('riddles.create')->middleware('auth');
    Route::post('/riddles/store', 'store')->name('riddles.store');
    Route::get('/riddles/{riddle}/edit', 'edit')->name('riddles.edit')->middleware('can:adminOrAuthor,riddle');
    Route::get('/riddles/{riddle}', 'show')->name('riddles.show');
    Route::put('/riddles/{riddle}', 'update')->name('riddles.update')->middleware('can:adminOrAuthor,riddle');
    Route::delete('/riddles/{riddle}', 'delete')->name('riddles.delete')->middleware('auth');
});

Route::get('/test', [RiddleController::class, 'test']);

Route::get('/inquiries/show', [InquiryController::class, 'show']);
Route::post('/inquiries/send', [InquiryController::class, 'store']);
Route::get('/inquiry/{inquiry}/reply', [InquiryController::class, 'reply'])->name('inquiry.reply');
Route::put('/inquiry/{inquiry}/reply', [InquiryController::class, 'update'])->name('reply.store');
Route::get('/inquiry/show', [InquiryController::class, 'show']);

Route::get('/rules', function () {
    return view('rules');
})->name('rules');

Route::get('/moderation', function () {
    return view('moderation');
})->name('moderation');

Route::get('/', [MainPageController::class, 'index'])->name('main');

Route::get('/schedule', [GameController::class, 'schedule'])->name('schedule');

Route::controller(MessageController::class)->middleware('auth')->group(function () {
    Route::get('chat', 'index')->name('chat');
    Route::post('message/sent', 'store');
});

Route::controller(SearchController::class)->group(function () {
    Route::get('/search', 'search')->name('search');
    Route::get('/s/test', 'test');
    Route::get('/update/stop', 'updateStopWords');
    Route::get('/get/synonyms', 'getSynonyms');
});

Route::get('/ohayou', [DashboardController::class, 'index'])->middleware('admin')->name('ohayou');

Route::get('/games/generate', [GameController::class, 'createTen'])->middleware('admin');
Route::get('/games/create', [GameController::class, 'create'])->middleware('admin')->name('games.create');
Route::post('/games/store', [GameController::class, 'store'])->middleware('admin')->name('games.store');
Route::get('/games/{game}/edit', [GameController::class, 'edit'])->middleware('admin')->name('games.edit');
Route::put('/games/{game}', [GameController::class, 'update'])->middleware('admin')->name('games.update');
Route::post('/games/{game}/start', [GameController::class, 'start'])->middleware('auth')->name('games.start');
Route::post('/games/{game}/end', [GameController::class, 'end'])->middleware('auth')->name('games.end');
Route::get('/games/generate', [GameController::class, 'generateTen'])->middleware('admin');
Route::get('/games/date/picker', [GameController::class, 'selectGameDate'])->middleware('auth');
Route::post('/games/host/store', [GameController::class, 'setHost'])->middleware('auth');

require __DIR__ . '/auth.php';
