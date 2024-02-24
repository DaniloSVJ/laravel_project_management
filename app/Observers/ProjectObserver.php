<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Project;
use Illuminate\Support\Facades\Auth; 

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $projectTitle = $project->title;
        $projectId = $project->id;

        $userName = Auth::user()->name;
        $userId = Auth::user()->id;

        Activity::create([
            'action' => 'create',
            'description' => 'Titulo do Projeto: '. $projectTitle,
            'user_id' => $userId,
            'project_id' => $projectId,
        ]);
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        $projectTitle = $project->title;
        $projectId = $project->id;

        $userName = Auth::user()->name;
        $userId = Auth::user()->id;

        Activity::create([
            'action' => 'update',
            'description' => 'Titulo do Projeto: '. $projectTitle,
            'user_id' => $userId,
            'project_id' => $projectId,
        ]);
    }

   
}
