<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Obtém o usuário autenticado

        $tasks = Task::where('user_id', $user->id)->paginate(10);
        $totalTasks = Task::where('user_id', $user->id)->count();
        $totalCompleted = Task::where('user_id', $user->id)->where('completed', true)->count();

        // Envia os dados para a view
        return view('tasks', compact('tasks', 'totalTasks', 'totalCompleted'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
        ]);

        Auth::user()->tasks()->create([
            'task' => $request->task,
            'completed' => false,
        ]);     

        return redirect('/tasks');
    }

    public function destroy($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->delete();

        return redirect('/tasks');
    }   

    public function update($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->completed = !$task->completed;
        $task->save();

        return redirect('/tasks');
    }
}