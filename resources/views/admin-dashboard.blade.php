@extends('layout.index')

@push('style')
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
        /* Admin Dashboard Styles */
    .admin-container {
        display: flex;
        min-height: 100vh;
        background: #f5f6fa;
    }
    
    /* Sidebar Styles */
    .admin-sidebar {
        width: 250px;
        background: #2c3e50;
        color: #fff;
        padding: 1rem;
    }
    
    .sidebar-header {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .sidebar-header h2 {
        margin: 0;
        font-size: 1.5rem;
    }
    
    .sidebar-nav {
        margin-top: 2rem;
    }
    
    .nav-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: background-color 0.3s;
    }
    
    .nav-item i {
        margin-right: 0.75rem;
    }
    
    .nav-item:hover, .nav-item.active {
        background: rgba(255,255,255,0.1);
    }
    
    /* Main Content Styles */
    .admin-content {
        flex: 1;
        padding: 2rem;
        overflow-y: auto;
    }
    
    .content-section {
        display: none;
    }
    
    .content-section.active {
        display: block;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .add-btn {
        background: #3498db;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .add-btn:hover {
        background: #2980b9;
    }
    
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
    }
    
    .modal.show {
        display: flex;
    }
    
    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        width: 100%;
        max-width: 500px;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .submit-btn {
        background: #2ecc71;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .cancel-btn {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
    }
    
    /* Data Grid Styles */
    .data-grid {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 1rem;
    }
    
    .data-grid table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-grid th, .data-grid td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    .data-grid th {
        background: #f2f2f2;
        font-weight: 500;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .admin-container {
            flex-direction: column;
        }
    
        .admin-sidebar {
            width: 100%;
        }
    
        .admin-content {
            padding: 1rem;
        }
    
        .modal-content {
            margin: 1rem;
        }
    }
    .data-grid table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .data-grid th,
    .data-grid td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #ddd;
        color: #333;
    }

    .data-grid th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .data-grid tr:hover {
        background-color: #f5f5f5;
    }

    .text-center {
        text-align: center;
    }
    
    .admin-container {
        display: flex;
        min-height: 100vh;
        background: #f5f6fa;
    }

    .admin-sidebar {
        width: 250px;
        background: #2c3e50;
        color: #fff;
        padding: 1rem;
    }

    .sidebar-nav {
        margin-top: 2rem;
    }

    .nav-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: #fff !important;
        text-decoration: none;
        transition: all 0.3s;
    }

    .nav-item i {
        margin-right: 0.75rem;
    }

    .admin-content {
        flex: 1;
        padding: 2rem;
        color: #333;
    }

/* Modal Styles */
.modal-content {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    width: 100%;
    max-width: 500px;
    color: #333;
}

.modal-content h3 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: #2c3e50;
    font-weight: 500;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #333;
    background: #fff;
}

.section-header h2 {
    color: #2c3e50;
    margin-bottom: 1rem;
}

.data-grid {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    color: #333;
}
.data-grid table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.data-grid th,
.data-grid td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #ddd;
    color: #333;
}

.data-grid th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.edit-btn, .delete-btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 0.5rem;
}

.edit-btn {
    background: #3498db;
    color: white;
}

.delete-btn {
    background: #e74c3c;
    color: white;
}
</style>
@endpush

@section('title', 'Admin Dashboard')

@section('dashboard')
<div class="admin-container">
    <!-- Sidebar Navigation -->
    <div class="admin-sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="#users" class="nav-item active" data-target="users-section">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="#projects" class="nav-item" data-target="projects-section">
                <i class="fas fa-project-diagram"></i> Projects
            </a>
            <a href="#tasks" class="nav-item" data-target="tasks-section">
                <i class="fas fa-tasks"></i> Tasks
            </a>
            <a href="{{ route('logout') }}" class="nav-item">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </div>

    <!-- Main Content Area -->
    <div class="admin-content">
        <!-- Users Section -->
        <div id="users-section" class="content-section active">
            <div class="section-header">
                <h2>Manage Users</h2>
                <button class="add-btn" onclick="toggleModal('userModal')">
                    <i class="fas fa-plus"></i> Add User
                </button>
            </div>
            <div class="data-grid">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <button class="edit-btn" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No users found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Projects Section -->
        <div id="projects-section" class="content-section">
            <div class="section-header">
                <h2>Manage Projects</h2>
                <button class="add-btn" onclick="toggleModal('projectModal')">
                    <i class="fas fa-plus"></i> Add Project
                </button>
            </div>
            <div class="data-grid">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->description }}</td>
                            <td>{{ $project->created_at ? $project->created_at->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                <button class="edit-btn">Edit</button>
                                <button class="delete-btn">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No projects found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tasks Section -->
        <div id="tasks-section" class="content-section">
            <div class="section-header">
                <h2>Manage Tasks</h2>
                <button class="add-btn" onclick="toggleModal('taskModal')">
                    <i class="fas fa-plus"></i> Add Task
                </button>
            </div>
            <div class="data-grid">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Project</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->project ? $task->project->name : 'No Project' }}</td>
                            <td>{{ $task->user ? $task->user->name : 'Unassigned' }}</td>
                            <td>{{ $task->status }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No tasks found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- User Modal -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <h3>Add New User</h3>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">Create User</button>
                <button type="button" class="cancel-btn" onclick="toggleModal('userModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Project Modal -->
<div id="projectModal" class="modal">
    <div class="modal-content">
        <h3>Add New Project</h3>
        <form action="{{ route('admin.projects.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="project_name">Project Name</label>
                <input type="text" id="project_name" name="project_name" required>
            </div>
            <div class="form-group">
                <label for="project_description">Description</label>
                <textarea id="project_description" name="description" rows="3"></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">Create Project</button>
                <button type="button" class="cancel-btn" onclick="toggleModal('projectModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Task Modal -->
<div id="taskModal" class="modal">
    <div class="modal-content">
        <h3>Add New Task</h3>
        <form action="{{ route('admin.tasks.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="task_name">Task Name</label>
                <input type="text" id="task_name" name="task_name" required>
            </div>
            <div class="form-group">
                <label for="project_id">Project</label>
                <select id="project_id" name="project_id" required>
                    <option value="">Select Project</option>
                </select>
            </div>
            <div class="form-group">
                <label for="assigned_to">Assign To</label>
                <select id="assigned_to" name="assigned_to" required>
                    <option value="">Select User</option>
                </select>
            </div>
            <div class="form-group">
                <label for="task_description">Description</label>
                <textarea id="task_description" name="description" rows="3"></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">Create Task</button>
                <button type="button" class="cancel-btn" onclick="toggleModal('taskModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <h3>Edit User</h3>
        <form id="editUserForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_name">Name</label>
                <input type="text" id="edit_name" name="name" required>
            </div>
            <div class="form-group">
                <label for="edit_email">Email</label>
                <input type="email" id="edit_email" name="email" required>
            </div>
            <div class="form-group">
                <label for="edit_password">New Password (leave blank to keep current)</label>
                <input type="password" id="edit_password" name="password">
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">Update User</button>
                <button type="button" class="cancel-btn" onclick="toggleModal('editUserModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navigation handling
    const navItems = document.querySelectorAll('.nav-item');
    const sections = document.querySelectorAll('.content-section');

    navItems.forEach(item => {
        if (!item.hasAttribute('href') || item.getAttribute('href') === '#') return;
        
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = item.getAttribute('data-target');

            // Update active states
            navItems.forEach(nav => nav.classList.remove('active'));
            sections.forEach(section => section.classList.remove('active'));

            item.classList.add('active');
            document.getElementById(targetId).classList.add('active');
        });
    });
});

function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.toggle('show');
}

function editUser(id, name, email) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_password').value = '';
    document.getElementById('editUserForm').action = `/admin/users/${id}`;
    toggleModal('editUserModal');
}
</script>
@endpush