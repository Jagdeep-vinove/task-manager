document.addEventListener('DOMContentLoaded', function() {
    setupNavigation();
    setupUserOperations();
    setupProjectOperations();
    setupTaskOperations();
});

function setupNavigation() {
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.content-section');

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetSection = link.getAttribute('data-section');
            
            navLinks.forEach(link => link.classList.remove('active'));
            sections.forEach(section => section.classList.remove('active'));
            
            link.classList.add('active');
            document.getElementById(targetSection).classList.add('active');
        });
    });
}

function setupUserOperations() {
    // Add User Form Submit
    const addUserForm = document.getElementById('addUserForm');
    if (addUserForm) {
        addUserForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(addUserForm);
            
            try {
                const response = await fetch(addUserForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Failed to add user');
                window.location.reload();
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', 'Failed to add user');
            }
        });
    }

    // Edit User Handler
    document.querySelectorAll('.edit[data-type="user"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.dataset.id;
            handleUserEdit(this);
        });
    });
}

function handleUserEdit(button) {
    const row = button.closest('tr');
    const userId = button.dataset.id;
    const name = row.cells[0].textContent;
    const email = row.cells[1].textContent;
    const isAdmin = row.cells[2].textContent.toLowerCase() === 'admin' ? '1' : '0';
    const originalContent = row.innerHTML;

    row.innerHTML = `
        <td><input type="text" name="name" value="${name}" required></td>
        <td><input type="email" name="email" value="${email}" required></td>
        <td>
            <select name="admin">
                <option value="0" ${isAdmin === '0' ? 'selected' : ''}>User</option>
                <option value="1" ${isAdmin === '1' ? 'selected' : ''}>Admin</option>
            </select>
        </td>
        <td>
            <button type="button" class="save-edit" data-type="user" data-id="${userId}">Save</button>
            <button type="button" class="cancel-edit">Cancel</button>
        </td>
    `;

    setupSaveHandler(row, 'user', userId, originalContent);
}

function setupProjectOperations() {
    // Add Project Form Submit
    const addProjectForm = document.getElementById('addProjectForm');
    if (addProjectForm) {
        addProjectForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(addProjectForm);
            
            try {
                const response = await fetch(addProjectForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Failed to add project');
                window.location.reload();
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', 'Failed to add project');
            }
        });
    }

    // Edit Project Handler
    document.querySelectorAll('.edit[data-type="project"]').forEach(btn => {
        btn.addEventListener('click', function() {
            handleProjectEdit(this);
        });
    });
}

function handleProjectEdit(button) {
    const row = button.closest('tr');
    const id = button.dataset.id;
    const name = row.cells[0].textContent.trim();
    const description = row.cells[1].textContent.trim();
    const originalContent = row.innerHTML;

    row.innerHTML = `
        <td><input type="text" name="project_name" value="${name}" required></td>
        <td><textarea name="description" required>${description}</textarea></td>
        <td>${row.cells[2].innerHTML}</td>
        <td>
            <button type="button" class="save-edit" data-type="project" data-id="${id}">Save</button>
            <button type="button" class="cancel-edit">Cancel</button>
        </td>
    `;

    setupSaveHandler(row, 'project', id, originalContent);
}

function setupTaskOperations() {
    // Add Task Form Submit
    const addTaskForm = document.getElementById('addTaskForm');
    if (addTaskForm) {
        addTaskForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(addTaskForm);
            
            try {
                const response = await fetch(addTaskForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Failed to add task');
                window.location.reload();
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', 'Failed to add task');
            }
        });
    }

    // Edit Task Handler
    document.querySelectorAll('.edit[data-type="task"]').forEach(btn => {
        btn.addEventListener('click', function() {
            handleTaskEdit(this);
        });
    });
}

function handleTaskEdit(button) {
    const row = button.closest('tr');
    const id = button.dataset.id;
    
    // Get current values
    const title = row.cells[0].textContent.trim();
    const project = row.cells[1].textContent.trim();
    const assignedTo = row.cells[2].textContent.trim();
    const status = row.cells[3].textContent.trim();
    const originalContent = row.innerHTML;

    // Create edit form with proper structure
    row.innerHTML = `
        <td>
            <input type="text" class="form-control" name="task_name" value="${title}" required>
        </td>
        <td>
            <select class="form-control" name="project_id" required>
                ${generateProjectOptions(project)}
            </select>
        </td>
        <td>
            <select class="form-control" name="assigned_to" required>
                ${generateUserOptions(assignedTo)}
            </select>
        </td>
        <td>
            <select class="form-control" name="status" required>
                <option value="pending" ${status === 'Pending' ? 'selected' : ''}>Pending</option>
                <option value="in-progress" ${status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                <option value="completed" ${status === 'Completed' ? 'selected' : ''}>Completed</option>
            </select>
        </td>
        <td>
            <div class="btn-group">
                <button type="button" class="btn btn-primary save-edit" data-type="task" data-id="${id}">
                    <i class="fas fa-save"></i> Save
                </button>
                <button type="button" class="btn btn-secondary cancel-edit">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </td>
    `;

    setupSaveHandler(row, 'task', id, originalContent);
}

// Helper function to generate project options
function generateProjectOptions(selectedProject) {
    const projects = JSON.parse(document.getElementById('projects-data').textContent);
    return projects.map(project => 
        `<option value="${project.id}" ${project.name === selectedProject ? 'selected' : ''}>
            ${project.name}
        </option>`
    ).join('');
}

// Helper function to generate user options
function generateUserOptions(selectedUser) {
    const users = JSON.parse(document.getElementById('users-data').textContent);
    return users.map(user => 
        `<option value="${user.id}" ${user.name === selectedUser ? 'selected' : ''}>
            ${user.name}
        </option>`
    ).join('');
}

function setupSaveHandler(row, type, id, originalContent) {
    const saveBtn = row.querySelector('.save-edit');
    const cancelBtn = row.querySelector('.cancel-edit');

    saveBtn.addEventListener('click', async () => {
        const formData = new FormData();
        formData.append('_method', 'PUT');

        switch(type) {
            case 'user':
                formData.append('name', row.querySelector('[name="name"]').value);
                formData.append('email', row.querySelector('[name="email"]').value);
                formData.append('admin', row.querySelector('[name="admin"]').value);
                break;
            case 'project':
                formData.append('project_name', row.querySelector('[name="project_name"]').value);
                formData.append('description', row.querySelector('[name="description"]').value);
                break;
            case 'task':
                formData.append('task_name', row.querySelector('[name="task_name"]').value);
                formData.append('description', row.querySelector('[name="description"]').value); // Add this line
                formData.append('project_id', row.querySelector('[name="project_id"]').value);
                formData.append('assigned_to', row.querySelector('[name="assigned_to"]').value);
                formData.append('status', row.querySelector('[name="status"]').value);
                break;
        }

        try {
            const response = await fetch(`/admin/${type}s/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();
            if (!response.ok) throw new Error(data.message || `Failed to update ${type}`);
            
            showAlert('success', `${type} updated successfully`);
            window.location.reload();
        } catch (error) {
            console.error('Error:', error);
            showAlert('error', error.message);
            row.innerHTML = originalContent;
            setupEditHandlers();
        }
    });

    cancelBtn.addEventListener('click', () => {
        row.innerHTML = originalContent;
        setupEditHandlers();
    });
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const container = document.querySelector('.main-content');
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => alertDiv.remove(), 3000);
}

// Initialize edit handlers
function setupEditHandlers() {
    setupUserOperations();
    setupProjectOperations();
    setupTaskOperations();
}