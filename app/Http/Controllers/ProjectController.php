<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function showUserProjects($projectrId)
    {
        $userProjects = User::join('user_projects', 'users.id', '=', 'user_projects.users_id')
            ->join('project', 'user_projects.project_id', '=', 'project.id')
            ->where('project.id', $projectrId)
            ->select('project.title', 'project.description', 'project.start_date', 'project.term_of_delivery',   'users.name')
            ->get();

        return response()->json($userProjects);
    }
    public function allUserProjects()
    {
        $userProjects = User::join('user_projects', 'users.id', '=', 'user_projects.users_id')
            ->join('project', 'user_projects.project_id', '=', 'project.id')
            ->select('project.title', 'project.description', 'project.start_date', 'project.term_of_delivery',   'users.name')
            ->get();

        return response()->json($userProjects);
    }

    
    public function index()
    {
        return Project::all();
    }


    public function store(Request $request)
    {
        if( Project::create($request->all())){
            return response()->json([
                'message'=>'Project registered successfully'
            ],201);
        }

        return response()->json([
            'message'=>'Error registering project'
        ],404);

       
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $project = Project::find($id);
        if( $project){
            return  $project;
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
        
        if (!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }

        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->description = $request->input('start_date');
        $project->description = $request->input('term_of_delivery');

        if ($project->save()) {
            return response()->json($project);
        }

        return response()->json([
            'message' => 'Error updating project'
        ], 500);
     
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
                'message'=>'Project deleted successfully!'
            ],200);
            
        }

        return response()->json([
            'message'=>'Project not found'
        ]);
        
        
    }
}
