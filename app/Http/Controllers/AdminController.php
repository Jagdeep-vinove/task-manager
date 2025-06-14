<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;



class AdminController extends Controller
{
    public function showDashboard()
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        
        $data = [
            'users' => User::all(),
            'projects' => Project::all(),
            'tasks' => Task::with(['project', 'user'])->get()
        ];
        
        return view('admin-dashboard', $data);
    }

    public function storeUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6',
                'admin' => 'required|boolean'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'admin' => $validated['admin']
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully',
                    'user' => $user
                ]);
            }

            return redirect()->back()->with('success', 'User created successfully');

        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create user: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
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
        try {
            $validated = $request->validate([
                'task_name' => 'required|string|max:255',
                'project_id' => 'required|exists:projects,id',
                'assigned_to' => 'required|exists:users,id',
                'description' => 'nullable|string'
            ]);

            $task = Task::create([
                'title' => $validated['task_name'],
                'project_id' => $validated['project_id'],
                'assigned_to' => $validated['assigned_to'],
                'description' => $validated['description'],
                'status' => 'pending'
            ]);

            return redirect()->back()->with('success', 'Task created successfully');
        } catch (\Exception $e) {
            Log::error('Task creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create task: ' . $e->getMessage()]);
        }
    }
    
    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'admin' => 'required|boolean'
            ]);

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'admin' => $validated['admin']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user'
            ], 500);
        }
    }
    
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateProject(Request $request, $id)
    {
        try {
            $project = Project::findOrFail($id);
            
            $validated = $request->validate([
                'project_name' => 'required|string|max:255',  // Changed from 'name'
                'description' => 'required|string'
            ]);

            $project->update([
                'name' => $validated['project_name'],  // Map to database column
                'description' => $validated['description']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully',
                'project' => $project
            ]);

        } catch (\Exception $e) {
            Log::error('Project update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update project: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteProject($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();

            return response()->json([
                'success' => true,
                'message' => 'Project deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete project: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteTask($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Task deletion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete task'
            ], 500);
        }
    }

    public function editTask($id)
    {
        try {
            $task = Task::findOrFail($id);
            return response()->json($task);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Task not found'], 404);
        }
    }

    public function updateTask(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);
            
            $validated = $request->validate([
                'task_name' => 'required|string|max:255',  // Changed from 'title'
                'description' => 'required|string',
                'project_id' => 'required|exists:projects,id',
                'assigned_to' => 'required|exists:users,id',
                'status' => 'required|in:pending,in-progress,completed'
            ]);

            $task->update([
                'title' => $validated['task_name'],  // Map to database column
                'description' => $validated['description'],
                'project_id' => $validated['project_id'],
                'assigned_to' => $validated['assigned_to'],
                'status' => $validated['status']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully',
                'task' => $task
            ]);

        } catch (\Exception $e) {
            Log::error('Task update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task: ' . $e->getMessage()
            ], 500);
        }
    }
}
