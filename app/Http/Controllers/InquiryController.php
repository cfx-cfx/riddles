<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Enums\InquiryStatus;
use Illuminate\Validation\Rule;
use App\Models\Inquiry;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();
        $inquiries = Inquiry::where('user_id', $user->id)->get();

        return view('inquiries.unclosed', compact('user', 'inquiries'));
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('surname')) {
            abort(403);
        }

        $validated = $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $inquiry = Inquiry::create([
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'user_id' => auth()->id(),
            'status' => InquiryStatus::NEW,
        ]);


        return redirect('/inquiries/show');
    }

    public function reply(Inquiry $inquiry): View
    {
        return view('inquiries.reply', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $inquiry->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        return redirect('/ohayou')->with('message', 'Ответ отправлен');
    }
}
