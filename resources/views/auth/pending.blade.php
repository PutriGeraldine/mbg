<h2>Pending Users</h2>
@if(session('success')) <p>{{ session('success') }}</p> @endif
<table border="1">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
    </tr>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->getRoleNames()->first() }}</td>
        <td>
            <form action="{{ route('approve.user', $user->id) }}" method="POST">
                @csrf
                <button type="submit">Approve</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>