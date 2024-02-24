<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if( Task::create($request->all())){
            return response()->json([
                'message'=>'Task registered successfully'
            ],201);
        }

        return response()->json([
            'message'=>'Error registering task'
        ],400);

     
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $task = Task::find($id);
        if( $task){
            return  $task;
        }
        return response()->json([
            'message'=>'Task not found'
        ],404);
      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        if( $task){
            $task->update($request->all());

            return $task;
        }
        return response()->json([
            'message'=>'Task not found'
        ]);
        return $task;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if($task){
            Task::destroy($id);

            return response()->json([
                'message'=>'Task deleted successfully'
            ],200);
            
        }

        return response()->json([
            'message'=>'Task not found'
        ],404);
    
    }
}
