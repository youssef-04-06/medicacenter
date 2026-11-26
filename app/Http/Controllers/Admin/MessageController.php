<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\PatientMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(15);
        $patientMessages = PatientMessage::with(['patient', 'doctor'])
            ->where('recipient_type', 'admin')
            ->latest()
            ->paginate(15, ['*'], 'patient_messages_page');

        return view('admin.messages.index', compact('contacts', 'patientMessages'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Message deleted successfully.');
    }

    public function reply(Request $request, Contact $contact)
    {
        $validated = $request->validate(['reply' => ['required', 'string', 'max:3000']]);
        $contact->update(['reply' => $validated['reply'], 'replied_by' => $request->user()->id, 'replied_at' => now()]);

        return back()->with('success', 'Reply sent to the patient.');
    }
}
