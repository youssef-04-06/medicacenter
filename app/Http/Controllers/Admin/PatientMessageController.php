<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatientMessage;
use Illuminate\Http\Request;

class PatientMessageController extends Controller
{
    public function index()
    {
        $messages = PatientMessage::with(['patient', 'doctor'])->where('recipient_type', 'admin')->latest()->paginate(15);

        return view('admin.patient-messages.index', compact('messages'));
    }

    public function reply(Request $request, PatientMessage $message)
    {
        abort_unless($message->recipient_type === 'admin', 404);
        $validated = $request->validate(['reply' => ['required', 'string', 'max:3000']]);
        $message->update(['reply' => $validated['reply'], 'replied_by' => $request->user()->id, 'replied_at' => now()]);

        return back()->with('success', 'Reply sent to the patient.');
    }
}
