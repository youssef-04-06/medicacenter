@extends('admin.layout')

@section('title', 'Users')

@section('content')
    <div class="topbar">
        <div>
            <span class="page-kicker">Access management</span>
            <h1>Users</h1>
            <p class="page-subtitle">Control account roles and keep the patient directory organized.</p>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Access</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $user->is_admin ? 'badge-admin' : 'badge-user' }}">
                                {{ $user->is_admin ? 'Admin' : 'User' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="actions-cell">
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_admin" value="{{ $user->is_admin ? 0 : 1 }}">
                                    <button type="submit" class="btn btn-sm btn-secondary">
                                        {{ $user->is_admin ? 'Revoke Admin' : 'Make Admin' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @else
                                <span style="color:#888;">This is you</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-state">No users yet.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $users->links() }}</div>
    </div>
@endsection
