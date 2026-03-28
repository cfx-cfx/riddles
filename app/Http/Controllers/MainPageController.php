<?php

namespace App\Http\Controllers;

use App\Models\Riddle;
use App\Models\Game;

use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function index()
    {
        $latest = Riddle::whereNotNull('published_at')->orderBy('id', 'desc')->take(5)->get();
        $time = Game::where('status', 'scheduled')->orderBy('id')->first()->starts_at;
        $isActive = Game::isActive();

        return view('main.main', ['latest' => $latest, 'time' => $time, 'isActive' => $isActive]);
    }
}
