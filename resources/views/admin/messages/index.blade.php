@extends('admin.layout')

@section('title', 'Messages')

@section('content')
    <div class="topbar">
        <div>
            <span class="page-kicker">Unified inbox</span>
            <h1>Messages</h1>
            <p class="page-subtitle">Review and reply to contact messages and authenticated patient conversations in one place.</p>
        </div>
    </div>

    <div class="table-container">
        <h3>Patient portal messages</h3>
        <table>
            <thead><tr><th>Patient</th><th>Subject</th><th>Message</th><th>Reply</th></tr></thead>
            <tbody>
                @forelse ($patientMessages as $message)
                    <tr>
                        <td>{{ $message->patient->name ?? 'Patient' }}<br><small>{{ $message->patient->email ?? '' }}</small></td>
                        <td>{{ $message->subject ?: 'Message' }}</td>
                        <td style="max-width:280px; white-space:pre-wrap;">{{ $message->message }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.patient-messages.reply', $message) }}">
                                @csrf
                                <textarea name="reply" rows="3" required placeholder="Reply to patient">{{ $message->reply }}</textarea>
                                <button type="submit" class="btn btn-sm btn-primary">{{ $message->reply ? 'Update reply' : 'Reply' }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty-state">No patient portal messages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $patientMessages->links() }}</div>
    </div>

    <div class="table-container" style="margin-top:30px;">
        <h3>Contact form messages</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Reply</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->subject }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($contact->message, 80) }}</td>
                        <td>
                            <form action="{{ route('admin.messages.reply', $contact) }}" method="POST" style="margin-bottom:8px;">
                                @csrf
                                <textarea name="reply" rows="2" placeholder="Reply to patient" required>{{ $contact->reply }}</textarea>
                                <button type="submit" class="btn btn-sm btn-primary">{{ $contact->reply ? 'Update reply' : 'Reply' }}</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.messages.destroy', $contact) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-state">No contact messages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $contacts->links() }}</div>
    </div>
@endsection
