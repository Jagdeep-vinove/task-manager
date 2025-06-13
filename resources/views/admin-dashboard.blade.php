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

form input:hover + label,
form input:not(:placeholder-shown) + label {
    top: -0.8rem;
    left: 1rem;
    font-size: 0.9rem;
    color: #2c3e50;
    background: transparent;
    padding: 0 0.2rem;
    border-radius: 4px;
}
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #333;
    background: rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.form-group select:hover + label,
.form-group select:not([value=""]) + label,
.form-group textarea:hover + label,
.form-group textarea:not(:placeholder-shown) + label {
    top: -0.8rem;
    left: 1rem;
    font-size: 0.9rem;
    color: #2c3e50;
    background: transparent;
    padding: 0 0.2rem;
    border-radius: 4px;
}

.form-group select option {
    background: white;
    color: #333;
}

.form-group {
    position: relative;
    margin-bottom: 1.5rem;
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
    background: white;
}

.form-group label {
    position: absolute;
    left: 0.75rem;
    top: 0.75rem;
    padding: 0 0.25rem;
    background: white;
    color: #666;
    font-size: 1rem;
    transition: all 0.3s ease;
    pointer-events: none;
}

.form-group input:focus + label,
.form-group input:not(:placeholder-shown) + label {
    transform: translateY(-1.4rem) scale(0.85);
    background: white;
    color: #333;
}

.modal-content {
    max-height: 90vh;
    overflow-y: auto;
}

/* Add these styles to your existing <style> section */
.edit-btn, .delete-btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 0.5rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.edit-btn {
    background: #3498db;
    color: white;
}

.delete-btn {
    background: #e74c3c;
    color: white;
}

.edit-btn:hover, .delete-btn:hover {
    opacity: 0.9;
}

td {
    vertical-align: middle;
}

.fas {
    pointer-events: none;
}
/* .delete-btn {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 5px;
}

.delete-btn:hover {
    background-color: #c82333;
}

.fas {
    margin-right: 5px;
} */
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
                <i class="fas fa-users"> Users </i> 
            </a>
            <a href="#projects" class="nav-item" data-target="projects-section">
                <i class="fas fa-project-diagram"> Projects </i> 
            </a>
            <a href="#tasks" class="nav-item" data-target="tasks-section">
                <i class="fas fa-tasks"> Tasks </i> 
            </a>
            <a href="#" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"> Logout </i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
            </form>
        </nav>
    </div>

    <!-- Main Content Area -->
    <div class="admin-content">
        <!-- Users Section -->
        <div id="users-section" class="content-section active">
            <div class="section-header">
                <h2>Manage Users</h2>
                <button class="add-btn" onclick="toggleModal('userModal')">
                    <i class="fas fa-plus"> Add User </i> 
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
                                    <i class="fas fa-edit"> Edit</i>
                                </button>
                                <button class="delete-btn" onclick="deleteUser({{ $user->id }})">
                                    <i class="fas fa-trash"> Delete</i> 
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
                    <i class="fas fa-plus"> Add Project </i> 
                </button>
            </div>
            <div class="data-grid">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->description }}</td>
                            <td>
                                <button type="button" class="edit-btn" onclick="editProject({{ $project->id }}, '{{ $project->name }}', '{{ addslashes($project->description) }}')">
                                    <i class="fas fa-edit"> Edit</i>
                                </button>
                                <button class="delete-btn" onclick="deleteProject({{ $project->id }})">
                                    <i class="fas fa-trash"> Delete</i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No projects found</td>
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
                    <i class="fas fa-plus"> Add Task </i> 
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->project ? $task->project->name : 'No Project' }}</td>
                            <td>{{ $task->user ? $task->user->name : 'Unassigned' }}</td>
                            <td>{{ $task->status }}</td>
                            <td>
                                <button class="edit-btn" onclick="editTask({{ $task->id }})">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="delete-btn" onclick="deleteTask({{ $task->id }})">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No tasks found</td>
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group">Welcome, testerWelcoWelcome, testerme, tester
                <input type="text" id="name" name="name" placeholder=" " required value="{{ old('name') }}">
                <label for="name">Full Name</label>
            </div>
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder=" " required value="{{ old('email') }}">
                <label for="email">Email Address</label>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder=" " required>
                <label for="password">Password</label>
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
                <input type="text" id="project_name" name="project_name" placeholder=" " required>
                <label for="project_name">Project Name</label>
            </div>
            <div class="form-group">
                <textarea id="project_description" name="description" rows="3" placeholder=" "></textarea>
                <label for="project_description">Description</label>
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
                <input type="text" id="task_name" name="task_name" placeholder=" " required>
                <label for="task_name">Task Name</label>
            </div>
            <div class="form-group">
                <select id="project_id" name="project_id" required>
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
                <label for="project_id">Project</label>
            </div>
            <div class="form-group">
                <select id="assigned_to" name="assigned_to" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <label for="assigned_to">Assign To</label>
            </div>
            <div class="form-group">
                <textarea id="task_description" name="description" rows="3" placeholder=" "></textarea>
                <label for="task_description">Description</label>
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">Create Task</button>
                <button type="button" class="cancel-btn" onclick="toggleModal('taskModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->Welcome, tester
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <h3>Edit User</h3>
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="text" id="edit_name" name="name" placeholder=" " required>
                <label for="edit_name">Name</label>
            </div>
            <div class="form-group">
                <input type="email" id="edit_email" name="email" placeholder=" " required>
                <label for="edit_email">Email</label>
            </div>
            <div class="form-group">
                <input type="password" id="edit_password" name="password" placeholder=" ">
                <label for="edit_password">New Password</label>
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">Update User</button>
                <button type="button" class="cancel-btn" onclick="toggleModal('editUserModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Project Modal -->
<div id="editProjectModal" class="modal">
    <div class="modal-content">
        <h3>Edit Project</h3>
        <form id="editProjectForm" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <input type="text" id="edit_project_name" name="name" placeholder=" " required>
                <label for="edit_project_name">Project Name</label>
            </div>
            <div class="form-group">
                <textarea id="edit_project_description" name="description" placeholder=" " required></textarea>
                <label for="edit_project_description">Description</label>
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">Update Project</button>
                <button type="button" class="cancel-btn" onclick="toggleModal('editProjectModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Task Modal -->
<div id="editTaskModal" class="modal">
    <div class="modal-content">
        <h3>Edit Task</h3>
        <form id="editTaskForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="text" id="edit_task_name" name="title" placeholder=" " required>
                <label for="edit_task_name">Task Name</label>
            </div>
            <div class="form-group">
                <select id="edit_project_id" name="project_id" required>
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
                <label for="edit_project_id">Project</label>
            </div>
            <div class="form-group">
                <select id="edit_assigned_to" name="assigned_to" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <label for="edit_assigned_to">Assign To</label>
            </div>
            <div class="form-group">
                <select id="edit_task_status" name="status" required>
                    <option value="pending">Pending</option>
                    <option value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
                <label for="edit_task_status">Status</label>
            </div>
            <div class="form-group">
                <textarea id="edit_task_description" name="description" rows="3" placeholder=" "></textarea>
                <label for="edit_task_description">Description</label>
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">Update Task</button>
                <button type="button" class="cancel-btn" onclick="toggleModal('editTaskModal')">Cancel</button>
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

// Add this to the existing script section in admin-dashboard.blade.php

function editUser(id, name, email) {
    // Set the form action URL
    document.getElementById('editUserForm').action = `/admin/users/${id}`;
    
    // Set the form values
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_password').value = '';
    
    // Show the modal
    toggleModal('editUserModal');
}

function editProject(id, name, description) {
    // Get the form and clear previous content
    document.getElementById('editProjectForm').action = `/admin/projects/${id}`;
    
    // Set values
    document.getElementById('edit_project_name').value = name;
    document.getElementById('edit_project_description').value = description;
    
    // // Add CSRF token if not present
    // if (!form.querySelector('input[name="_token"]')) {
    //     const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    //     const csrfInput = document.createElement('input');
    //     csrfInput.type = 'hidden';
    //     csrfInput.name = '_token';
    //     csrfInput.value = csrfToken;
    //     form.prepend(csrfInput);
    // }
    // Show modal
    toggleModal('editProjectModal');
}

function editTask(id) {
    // Fetch task data first
    fetch(`/admin/tasks/${id}/edit`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(task => {
        // Set the form action
        document.getElementById('editTaskForm').action = `/admin/tasks/${id}`;
        
        // Set form values
        document.getElementById('edit_task_name').value = task.title;
        document.getElementById('edit_project_id').value = task.project_id;
        document.getElementById('edit_assigned_to').value = task.assigned_to;
        document.getElementById('edit_task_status').value = task.status;
        document.getElementById('edit_task_description').value = task.description;
        
        // Show the modal
        toggleModal('editTaskModal');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to load task details');
    });
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        fetch(`/admin/users/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Failed to delete user');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the user');
        });
    }
}

function deleteProject(id) {
    if (confirm('Are you sure you want to delete this project?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        fetch(`/admin/projects/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Failed to delete project');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the project');
        });
    }
}

function deleteTask(id) {
    if (confirm('Are you sure you want to delete this task?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        fetch(`/admin/tasks/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Failed to delete task');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the task');
        });
    }
}
</script>
@endpush