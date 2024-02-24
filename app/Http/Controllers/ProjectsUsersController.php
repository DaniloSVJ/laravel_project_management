<?php

namespace App\Http\Controllers;
use App\Models\UserProject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectsUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserProject::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        if( UserProject::create($request->all())){
            return response()->json([
                'message'=>'User successfully introduced into the project'
            ],201);
        }

        return response()->json([
            'message'=>'Error when introducing User to the project'
        ],400);

       
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $project = UserProject::find($id);
        if( $project){
            return response()->json(project,404);
        }
        return response()->json([
            'message'=>'Project not found'
        ],404);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if( $project){
            $project->update($request->all());

            return $project;
        }
        return response()->json([
            'message'=>'Association not found'
        ]);
        
     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if( $project){
            Project::destroy($id);

            return response()->json([
                'message'=>'Association dissolved'
            ],200);
            
        }

        return response()->json([
            'message'=>'Association not found'
        ],404);
        
        
    }
}