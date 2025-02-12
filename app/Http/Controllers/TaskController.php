<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        $totalTasks = $tasks->count(); 
        $totalCompleted = Task::where('completed', true)->count();

        return view('tasks', compact('tasks', 'totalTasks', 'totalCompleted'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
        ]);

        Task::create([
            'task' => $request->task,
            'completed' => false,
        ]);

        return redirect('/');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect('/');
    }   
}