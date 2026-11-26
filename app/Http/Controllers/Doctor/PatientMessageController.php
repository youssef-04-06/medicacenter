<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\PatientMessage;
use Illuminate\Http\Request;

class PatientMessageController extends Controller
{
    public function index(Request $request)
    {
        $doctor = $request->user()->doctor;
        $messages = PatientMessage::with('patient')->where('recipient_type', 'doctor')->where('doctor_id', $doctor->id)->latest()->paginate(15);

        return view('portal.doctor-messages', compact('messages', 'doctor'));
    }

    public function reply(Request $request, PatientMessage $message)
    {
        abort_unless($message->recipient_type === 'doctor' && (int) $message->doctor_id === (int) $request->user()->doctor->id, 403);
        $validated = $request->validate(['reply' => ['required', 'string', 'max:3000']]);
        $message->update(['reply' => $validated['reply'], 'replied_by' => $request->user()->id, 'replied_at' => now()]);

        return back()->with('success', 'Reply sent to the patient.');
    }
}
