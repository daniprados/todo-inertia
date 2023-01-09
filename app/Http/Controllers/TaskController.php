<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Task;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $tasks = Auth::user()->tasks()->where("done", "=", 0)->get(); //Task::where([['done', "=", 0], ['user_id', "=", Auth::user()->id]])->get();
        $done = Auth::user()->tasks()->where("done", "=", 1)->get(); //Task::where([['done', "=", 1], ['user_id', "=", Auth::user()->id]])->get();

        return Inertia::render('Tasks', [
            'tasks' => $tasks,
            'done' => $done,
        ]);
    }

    /**
     * Add new task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validated = $request->validate(["task" => "required"]);

        $task = new Task;

        $task->name = $validated["task"];
        $task->user_id = Auth::user()->id;
        $task->done = 0;
        $task->save();

        return response()->json($task);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $task = Task::where([['id', "=", $id], ['user_id', "=", Auth::user()->id]])->first();
        $task->done = 1;
        $task->save();

        $tasks = Auth::user()->tasks()->where("done", "=", 0)->get(); 
        $done = Auth::user()->tasks()->where("done", "=", 1)->get(); 
        
        return response()->json([
            'tasks' => $tasks,
            'done' => $done,
        ]);
    }


    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $task = Task::where([['id', "=", $id], ['user_id', "=", Auth::user()->id]])->first();

        $task->done = 0;
        $task->save();
        
        $tasks = Auth::user()->tasks()->where("done", "=", 0)->get(); 
        $done = Auth::user()->tasks()->where("done", "=", 1)->get(); 
        
        return response()->json([
            'tasks' => $tasks,
            'done' => $done,
        ]);
    }
}
