<section id="tasks" class="section">
    <header>
        <h1>Tasks Management</h1>
    </header>

    <!-- Add Task Form -->
    <section class="form-section">
        <h2>Add New Task</h2>
        <form action="{{ route('admin.tasks.store') }}" method="POST" id="addTaskForm">
            @csrf
            <input type="text" name="task_name" placeholder="Task Title" required>
            <textarea name="description" placeholder="Task Description" rows="3" required></textarea>
            
            <select name="project_id" required>
                <option value="" disabled selected>Select Project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
            
            <select name="assigned_to" required>
                <option value="" disabled selected>Assign To</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <select name="status" required>
                <option value="pending">Pending</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
            
            <button type="submit">Add Task</button>
        </form>
    </section>

    <!-- Tasks Table -->
    <section class="table-section">
        <h2>Tasks List</h2>
        <table id="tasksTable">
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
                @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->project->name }}</td>
                    <td>{{ $task->user->name }}</td>
                    <td>{{ $task->status }}</td>
                    <td>
                        <button class="action-btn edit" data-type="task" data-id="{{ $task->id }}">
                            <i class="fa fa-pen"></i>
                        </button>
                        <button class="action-btn delete" data-type="task" data-id="{{ $task->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</section>