<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $games = Game::where('status', '<>', 'finished')->with('riddle')->get();
        $inquiries = Inquiry::where('status', '<>', 'closed')->get();

        return view('ohayou', compact('games', 'inquiries'));
    }
}
