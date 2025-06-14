@extends('layout.index')

@push('style')
<link rel="stylesheet" href="css/new.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
/* Add this to ensure only active section is visible */
.content-section {
    display: none;
}

.content-section.active {
    display: block;
}
</style>
@endpush

@section('title', 'Admin Dashboard')

@section('dashboard')
<div class="dashboard">
    <aside class="sidebar">
        <h2 class="logo">🚀 TaskAdmin</h2>
        <nav>
            <ul>
                <li>
                    <a href="#" class="nav-link active" data-section="dashboard-section">
                        <i class="fas fa-chart-bar"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link" data-section="users-section">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link" data-section="projects-section">
                        <i class="fas fa-folder-open"></i> Projects
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link" data-section="tasks-section">
                        <i class="fas fa-tasks"></i> Tasks
                    </a>
                </li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </aside>

    <main class="main-content">
        <!-- Dashboard Overview Section -->
        <div id="dashboard-section" class="content-section active">
            <header>
                <h1>Dashboard Overview</h1>
                <div class="admin-info">👋 Welcome, {{ Auth::user()->name }}</div>
            </header>

            <section class="stats-section">
                <div class="stat-card blue-glow">
                    <i class="fas fa-users stat-icon"></i>
                    <h2>Users</h2>
                    <p class="stat-number">{{ count($users) }}</p>
                </div>
                <div class="stat-card purple-glow">
                    <i class="fas fa-folder-open stat-icon"></i>
                    <h2>Projects</h2>
                    <p class="stat-number">{{ count($projects) }}</p>
                </div>
                <div class="stat-card green-glow">
                    <i class="fas fa-tasks stat-icon"></i>
                    <h2>Tasks</h2>
                    <p class="stat-number">{{ count($tasks) }}</p>
                </div>
            </section>
        </div>

        <!-- Users Section -->
        <div id="users-section" class="content-section">
            @include('admin.sections.users')
        </div>

        <!-- Projects Section -->
        <div id="projects-section" class="content-section">
            @include('admin.sections.projects')
        </div>

        <!-- Tasks Section -->
        <div id="tasks-section" class="content-section">
            @include('admin.sections.tasks')
        </div>
    </main>
</div>

<script id="projects-data" type="application/json">
    {!! json_encode($projects) !!}
</script>
<script id="users-data" type="application/json">
    {!! json_encode($users) !!}
</script>

@push('script')
<script src="{{ asset('js/admin.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navigation handling
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.content-section');

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetSection = link.getAttribute('data-section');
            
            // Remove active class from all links and sections
            navLinks.forEach(link => link.classList.remove('active'));
            sections.forEach(section => section.classList.remove('active'));
            
            // Add active class to clicked link and corresponding section
            link.classList.add('active');
            document.getElementById(targetSection).classList.add('active');
        });
    });
});

// Keep your existing modal and CRUD operation functions here
</script>
@endpush
@endsection