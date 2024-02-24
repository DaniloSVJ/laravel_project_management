<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Activity::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if( Activity::create($request->all())){
            return response()->json([
                'message'=>'Activity registered successfully'
            ],201);
        }

        return response()->json([
            'message'=>'Error registering activity'
        ],400);

       
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $activity = Activity::find($id);
        if( $activity){
            return  $activity;
        }
        return response()->json([
            'message'=>'Activity not found'
        ],404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $activity = Activity::find($id);
        if( $activity){
            $activity->update($request->all());

            return $activity;
        }
        return response()->json([
            'message'=>'Activity not found'
        ],404);
        

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $activity = Activity::find($id);
        if( $activity){
            Activity::destroy($id);

            return response()->json([
                'message'=>'Project deleted successfully'
            ],200);
        }

        return response()->json([
            'message'=>'Activity not found'
        ],404);
        
        
    }
}
