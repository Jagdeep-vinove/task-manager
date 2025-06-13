@extends('layout.index')

@push('style')
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    .dashboard-container {
        min-height: 100vh;
        padding: 2rem;
        background: rgb(18, 62, 255);
    }
    
    .dashboard-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 2rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        margin-bottom: 2rem;
    }
    
    .dashboard-nav h2 {
        color: #ffffff;
        margin: 0;
    }
    
    .tasks-wrapper {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 2rem;
    }
    
    .tasks-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .tasks-header h3 {
        color: #ffffff;
        margin: 0;
    }
    
    .task-filters {
        display: flex;
        gap: 1rem;
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .filter-btn.active, .filter-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }
    
    .tasks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .task-card {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 1.5rem;
        transition: transform 0.3s ease;
    }
    
    .task-card:hover {
        transform: translateY(-5px);
    }
    
    .task-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
    }
    
    .task-header h4 {
        color: #ffffff;
        margin: 0;
    }
    
    .task-date {
        color: #ffffff;
        font-size: 0.9rem;
        opacity: 0.8;
    }
    
    .task-body {
        color: #ffffff;
        margin-bottom: 1.5rem;
    }
    
    .task-status select {
        width: 100%;
        padding: 0.5rem;
        border-radius: 6px;
        border: none;
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        cursor: pointer;
    }
    
    .task-comments {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding-top: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .task-comments h5 {
        color: #ffffff;
        margin-bottom: 1rem;
    }
    
    .comments-list {
        max-height: 200px;
        overflow-y: auto;
        margin-bottom: 1rem;
    }
    
    .comment {
        background: rgba(255, 255, 255, 0.1);
        padding: 0.8rem;
        border-radius: 8px;
        margin-bottom: 0.8rem;
    }
    
    .comment p {
        color: #ffffff;
        margin: 0 0 0.5rem 0;
    }
    
    .comment small {
        color: rgba(255, 255, 255, 0.7);
    }
    
    .comment-form {
        display: flex;
        gap: 0.5rem;
    }
    
    .comment-form input {
        flex: 1;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }
    
    .comment-form button {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.3);
        color: #ffffff;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .comment-form button:hover {
        background: rgba(255, 255, 255, 0.4);
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }
    
        .tasks-header {
            flex-direction: column;
            gap: 1rem;
        }
    
        .tasks-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
@endpush

@section('title', 'Task Dashboard')

@section('dashboard')

<div class="dashboard-container">
    <nav class="dashboard-nav">
        <h2>Welcome, {{ Auth::user()->name }}</h2>
        <a href="{{ route('login') }}" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>

    <div class="tasks-wrapper">
        <div class="tasks-header">
            <h3>My Tasks</h3>
            <div class="task-filters">
                <button class="filter-btn active" data-status="all">All</button>
                <button class="filter-btn" data-status="pending">Pending</button>
                <button class="filter-btn" data-status="in-progress">In Progress</button>
                <button class="filter-btn" data-status="completed">Completed</button>
            </div>
        </div>

        <div class="tasks-grid">
            @foreach($tasks as $task)
            <div class="task-card" data-status="{{ $task->status }}">
                <div class="task-header">
                    <h4>{{ $task->title }}</h4>
                    <span class="task-date">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
                </div>
                
                <div class="task-body">
                    <p>{{ $task->description }}</p>
                    
                    <div class="task-status">
                        <form action="{{ route('update.task.status', $task->id) }}" method="POST" class="status-form">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()">
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in-progress" {{ $task->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="task-comments">
                    <h5>Comments</h5>
                    <div class="comments-list">
                        @foreach($task->comments as $comment)
                        <div class="comment">
                            <p>{{ $comment->content }}</p>
                            <small>{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        @endforeach
                    </div>
                    
                    <form action="{{ route('add.comment', $task->id) }}" method="POST" class="comment-form">
                        @csrf
                        <input type="text" name="content" placeholder="Add a comment..." required>
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const taskCards = document.querySelectorAll('.task-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const status = btn.dataset.status;
            
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            taskCards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endpush