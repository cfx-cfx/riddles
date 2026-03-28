<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;
use App\Models\Message;
use App\Enums\GameStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use App\Events\GameStarted;
use App\Events\GameEnded;

class GameController extends Controller
{
    public function create()
    {
        return view('games.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'starts_at' => ['required', 'date'],
            'status' => [Rule::enum(GameStatus::class)],
            'host_name' => 'nullable|string',
        ]);

        if ($validated['host_name']) {
            $hostUser = User::where('name', $validated['host_name'])->firstOrFail();
            $hostUserId = $hostUser->id;
        }
        Game::create([
            'starts_at' => Carbon::parse($validated['starts_at']),
            'status' =>  $validated['status'],
            'host_user_id' => $hostUserId ?? null,
        ]);

        return redirect('/ohayou')
            ->with('message', 'Игра создана');
    }

    public function edit(Game $game)
    {
        $hostName = $game->hostUser?->name;

        return view('games.edit', compact('game', 'hostName'));
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'starts_at' => ['required', 'date'],
            'status' => [Rule::enum(GameStatus::class)],
            'host_name' => 'nullable|string|exists:users,name',
        ]);

        $hostUserId = null;
        if ($validated['host_name']) {
            $hostUserId = User::where('name', $validated['host_name'])->value('id');
        }

        $newStatus = GameStatus::from($validated['status']);

        if ($game->status !== $newStatus) {
            if (! $game->status->canTransitionTo($newStatus)) {
                abort(403, 'Недопустимый переход статуса');
            }
        }

        $game->update([
            'starts_at' => $validated['starts_at'],
            'host_user_id' => $hostUserId,
            'status' => $newStatus,
        ]);

        return redirect('/ohayou')
            ->with('message', 'Игра изменена');
    }

    public function start(Game $game)
    {
        $game->status = 'active';
        $game->save();

        broadcast(new GameStarted());

        return redirect('chat');
    }

    public function end(Game $game)
    {
        $game->status = 'finished';
        $game->ends_at = now();
        $game->players_count = Message::where('game_id', $game->id)
            ->distinct('user_id')
            ->count('user_id');
        $game->save();

        broadcast(new GameEnded());

        return redirect('chat');
    }
}
