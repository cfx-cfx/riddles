<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Riddle;
use App\Enums\RiddleStatus;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use App\Models\Game;
use App\Models\Message;



class RiddleController extends Controller
{
    public function index()
    {
        if (auth()->user()->can('adminOnly', Riddle::class)) {
            $riddles = Riddle::paginate(10);
        } else {
            $riddles = Riddle::where('status', 'published')->paginate(10);
        }
        return view('riddles.index', compact('riddles'));
    }

    public function show(Request $request, Riddle $riddle): View
    {
        return view('riddles/show', compact('riddle'));
    }

    public function create(): View
    {
        return view('riddles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('surname')) {  // honeypot
            abort(403);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'riddle' => 'required|string|unique:riddles',
            'solution_text' => 'required|string',
            'status' => [Rule::enum(RiddleStatus::class)],
            'searchable' => 'string|nullable',
        ]);

        if (isset($validated['status']) && $validated['status'] === RiddleStatus::PUBLISHED) {
            $validated['published_at'] = now();
        }

        $riddle = auth()->user()->riddles()->create($validated);

        if (auth()->user()->is_admin) return redirect()->route('riddles.show', ['riddle' => $riddle]);
        return redirect()->route('riddles.show', ['riddle' => $riddle])->with('message', 'Ваша данетка на модерации');
    }

    public function edit(Riddle $riddle): View
    {
        $games = Game::get();

        return view('riddles.edit', compact('riddle', 'games'));
    }

    public function update(Request $request, Riddle $riddle): RedirectResponse
    {
        if ($request->filled('surname')) {  // honeypot
            abort(403);
        }
        $previousStatus = $riddle->status;
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'riddle' => ['required', 'string', Rule::unique('riddles')->ignore($riddle->id)],
            'solution_text' => 'required|string',
            'status' => [Rule::enum(RiddleStatus::class)],
            'game_id' => ['nullable', 'exists:games,id'],
        ]);

        if (auth()->user()->is_admin == false) {
            $validated['status'] = RiddleStatus::DRAFT;
        }

        if ($validated['status'] === RiddleStatus::PUBLISHED->value && $previousStatus->value !== $validated['status']) {

            $validated['published_at'] = now();
        }

        $riddle->update($validated);

        return redirect()->route('riddles.show', ['riddle' => $riddle]);
    }

    public function delete($riddle): RedirectResponse
    {
        Riddle::delete($riddle);

        return redirect('riddles.index');
    }

    public function test()
    {
        return Riddle::where('solution_text', 'like', '%овый год%')->get();
    }
}
