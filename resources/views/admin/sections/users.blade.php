<section id="users" class="section">
    <header>
        <h1>Users Management</h1>
    </header>

    <!-- Add User Form -->
    <section class="form-section">
        <h2>Add New User</h2>
        <form action="{{ route('admin.users.store') }}" method="POST" id="addUserForm">
            @csrf
            <div class="form-group">
                <input type="text" name="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <select name="admin" required>
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </section>

    <!-- Users Table -->
    <section class="table-section">
        <h2>Users List</h2>
        <table id="usersTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->admin ? 'Admin' : 'User' }}</td>
                    <td>
                        <button class="action-btn edit" data-id="{{ $user->id }}" data-type="user">
                            <i class="fa fa-pen"></i>
                        </button>
                        <button class="action-btn delete" data-id="{{ $user->id }}" data-type="user">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</section>