<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Message;
use App\Models\Riddle;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{

    public function index()
    {
        $game = Game::current(); // активная игра
        $latestFinished = $game ? null : Game::latestFinished();

        if ($game) {
            $riddle = Riddle::where('game_id', $game->id)->first();

            $messages = Message::whereNull('parent_id')->with(['user', 'replies.user'])
                ->where('game_id', $game->id)
                ->get()
                ->sortBy('id');

            $scheduledGame = null;
        } else {
            $messages = Message::whereNull('parent_id')->with(['user', 'replies.user'])
                ->where('game_id', $latestFinished?->id)
                ->where('stage', 'discussion')
                ->get();

            $scheduledGame = Game::where('status', 'scheduled')->orderBy('id')->first();

            $riddle = Riddle::where('game_id', $latestFinished->id)->first();
        }


        return view('games.chat', compact('messages', 'game',  'scheduledGame', 'latestFinished', 'riddle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'string|required'
        ]);
        $userId = auth()->user()->id;

        $message = Message::make([
            'content' => $request->content,
            'user_id' => $userId,
        ]);
        $message->parent_id = $request->parent_id ?? null;

        $game = Game::current();

        if ($game) {
            $message->stage = 'game';
            $message->game_id = $game->id;
            $type = match (true) {
                $userId === $game->host_user_id => 'host',
                default => 'user',
            };
            $message->type = $type;
        } else {
            $latestFinished = Game::latestFinished();
            $message->stage = 'discussion';
            $message->game_id = $latestFinished->id;
            $message->type = 'user';
        }
        $message->save();

        $gameOrDiscussion = $game ?? $latestFinished;

        Log::info('Broadcast channel', ['game' => $gameOrDiscussion->id]);
        broadcast(new MessageSent($message, $gameOrDiscussion)); //->toOthers();

        return back();
    }
}
