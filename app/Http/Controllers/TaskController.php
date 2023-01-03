<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
    }

    public function store(Request $resquest)
    {
        $resquest->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $task = new Task();
        $task->title = $resquest->title;
        $task->description = $resquest->description;
        $task->save();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $task = Task::find($id); // buscando por id la Task

        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();
    }

    public function destroy($id)
    {
        Task::destroy($id);
    }
}
