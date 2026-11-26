<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\PatientMessage;
use App\Models\Contact;
use Illuminate\Http\Request;

class PatientMessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = PatientMessage::with('doctor')->where('user_id', $request->user()->id)->latest()->get();
        $legacyMessages = Contact::where(function ($query) use ($request) {
                $query->where('user_id', $request->user()->id)->orWhere('email', $request->user()->email);
            })
            ->latest()
            ->get()
            ->map(function (Contact $contact) {
                return (object) [
                    'recipient_type' => 'admin',
                    'doctor' => null,
                    'subject' => $contact->subject,
                    'message' => $contact->message,
                    'reply' => $contact->reply,
                    'replied_at' => $contact->replied_at,
                    'created_at' => $contact->created_at,
                ];
            });
        $messages = $messages->concat($legacyMessages)->sortByDesc('created_at')->values();
        $doctors = Doctor::orderBy('name')->get(['id', 'name']);

        return view('portal.messages', compact('messages', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_type' => ['required', 'in:admin,doctor'],
            'doctor_id' => ['nullable', 'required_if:recipient_type,doctor', 'exists:doctors,id'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        PatientMessage::create([
            'user_id' => $request->user()->id,
            'doctor_id' => $validated['doctor_id'] ?? null,
            'recipient_type' => $validated['recipient_type'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Message sent successfully.');
    }
}
