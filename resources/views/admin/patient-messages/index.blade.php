@extends('admin.layout')
@section('title', 'Patient Messages')
@section('content')
<div class="topbar"><div><span class="page-kicker">Inbox</span><h1>Patient Messages</h1><p class="page-subtitle">Reply to messages sent directly to the admin team.</p></div></div>
<div class="table-container"><table><thead><tr><th>Patient</th><th>Subject</th><th>Message</th><th>Reply</th></tr></thead><tbody>@forelse ($messages as $message)<tr><td>{{ $message->patient->name }}<br><small>{{ $message->patient->email }}</small></td><td>{{ $message->subject ?: 'Message' }}</td><td style="max-width:280px;white-space:pre-wrap">{{ $message->message }}</td><td><form method="POST" action="{{ route('admin.patient-messages.reply', $message) }}">@csrf<textarea name="reply" rows="3" required placeholder="Reply to patient">{{ $message->reply }}</textarea><button type="submit" class="btn btn-sm btn-primary">{{ $message->reply ? 'Update reply' : 'Reply' }}</button></form></td></tr>@empty<tr><td colspan="4" class="empty-state">No patient messages yet.</td></tr>@endforelse</tbody></table><div class="pagination-wrap">{{ $messages->links() }}</div></div>
@endsection
