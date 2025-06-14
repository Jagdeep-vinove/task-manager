<section id="projects" class="section">
    <header>
        <h1>Projects Management</h1>
    </header>

    <!-- Add Project Form -->
    <section class="form-section">
        <h2>Add New Project</h2>
        <form action="{{ route('admin.projects.store') }}" method="POST" id="addProjectForm">
            @csrf
            <input type="text" name="project_name" placeholder="Project Name" required>
            <textarea name="description" placeholder="Project Description" rows="3" required></textarea>
            <button type="submit">Add Project</button>
        </form>
    </section>

    <!-- Projects Table -->
    <section class="table-section">
        <h2>Projects List</h2>
        <table id="projectsTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->created_at->format('Y-m-d') }}</td>
                    <td>
                        <button class="action-btn edit" data-type="project" data-id="{{ $project->id }}">
                            <i class="fa fa-pen"></i>
                        </button>
                        <button class="action-btn delete" data-type="project" data-id="{{ $project->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</section>