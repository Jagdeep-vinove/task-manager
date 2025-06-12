<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        
        $tasks = Task::where('assigned_to', Auth::id())
                    ->with('comments')
                    ->get();
                    
        return view('user', ['tasks'=>$tasks]);
    }

    public function updateStatus(Request $request, $taskId)
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        $task = Task::find($taskId);
        
        if($task) {
            $task->status = $request->status;
            $task->save();
        }

        return back();
    }

    public function addComment(Request $request, $taskId)
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $comment = new Comment();
        $comment->task_id = $taskId;
        $comment->user_id = Auth::id();
        $comment->content = $request->content;
        $comment->save();

        return back();
    }
}
