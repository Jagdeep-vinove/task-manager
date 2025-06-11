<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showDashboard()
    {
        $users = User::all();
        $projects = Project::all();
        $tasks = Task::with(['project', 'user'])->get();
        
        // Add this line to debug
        // dd($projects);
        
        return view('admin-dashboard', compact('users', 'projects', 'tasks'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'User created successfully');
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Project::create([
            'name' => $request->project_name,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Project created successfully');
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'description' => 'required|string',
        ]);

        Task::create([
            'title' => $request->task_name,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Task created successfully');
    }
}
