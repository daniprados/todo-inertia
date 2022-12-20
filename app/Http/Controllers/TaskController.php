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
        //
        $tasks = Task::where([['done', "=", 0], ['user_id', "=", Auth::user()->id]])->get();
        $done = Task::where([['done', "=", 1], ['user_id', "=", Auth::user()->id]])->get();

        return Inertia::render('Tasks', [
            'tasks' => $tasks,
            'done' => $done,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        //dd($request);
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
        //
        $task = Task::where([['id', "=", $id], ['user_id', "=", Auth::user()->id]])->first();

        $task->done = 1;
        $task->save();

        // Retornar totes les tasques cada vegada és poc eficient.
        $tasks = Task::where([['done', "=", 0], ['user_id', "=", Auth::user()->id]])->get();
        $done = Task::where([['done', "=", 1], ['user_id', "=", Auth::user()->id]])->get();
        
        //dd($tasques);
        return response()->json([
            'tasks' => $tasks,
            'done' => $done,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        //
        $task = Task::where([['id', "=", $id], ['user_id', "=", Auth::user()->id]])->first();

        $task->done = 0;
        $task->save();
        
        //dd($tasques);
        $tasks = Task::where([['done', "=", 0], ['user_id', "=", Auth::user()->id]])->get();
        $done = Task::where([['done', "=", 1], ['user_id', "=", Auth::user()->id]])->get();
        
        //dd($tasques);
        return response()->json([
            'tasks' => $tasks,
            'done' => $done,
        ]);
    }
}
