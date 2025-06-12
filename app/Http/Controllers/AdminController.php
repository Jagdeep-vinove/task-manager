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
        $users = User::all();
        $projects = Project::all();
        $tasks = Task::with(['project', 'user'])->get();
        
        // Add this line to debug
        // dd($projects);
        
        return view('admin-dashboard', compact('users', 'projects', 'tasks'));
    }

    public function storeUser(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6',
            ]);

            // Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            if (!$user) {
                throw new \Exception('Failed to create user');
            }

            Log::info('User created successfully', ['user_id' => $user->id]);

            return redirect()->back()->with('success', 'User created successfully');

        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
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
    
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $id,
        ]);

        // Debug logging
        Log::info('Password field value: ' . ($request->password ? 'not empty' : 'empty'));

        try {
            // Update basic info
            $user->name = $request->name;
            $user->email = $request->email;

            // Handle password update
            if ($request->has('password') && !empty($request->password)) {
                $user->password = bcrypt($request->password);
                Log::info('Password being updated');
            }

            $user->save();
            Log::info('User updated successfully');

            return back()->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return back()->with('error', 'Failed to update user');
        }
    }
    
    public function updateProject(Request $request, $id)
    {
        try {
            $project = Project::find($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string'
            ]);

            $project->update($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Project updated successfully'
                ]);
            }

            return redirect()->back()->with('success', 'Project updated successfully');
            
        } catch (\Exception $e) {
            Log::error('Project update failed: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update project'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to update project');
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
            Log::error('Project deletion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete project'
            ], 500);
        }
    }
}
