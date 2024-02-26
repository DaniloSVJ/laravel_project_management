<?php

namespace Tests\App;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;

class TaskControllerTest extends TestCase
{
    use DatabaseTransactions;

    # php artisan test --filter=AuthControllerTest::test_index_method_returns_all_tasks
    public function test_index_method_returns_all_tasks()
    {
        $user = User::factory()->create();
        $projectId = Project::withoutEvents(function () {
            return Project::factory()->create()->id;
        });
        $token = $user->createToken('Bearer Token')->plainTextToken;

        Task::create([
            "title"=> "Projeto Novo",
            "description"=>"Projeto Novo",
            "status"=>"inicio",
            "responsable"=>$user->id,
            "project_id"=>$projectId,
            "start_date"=>"2024-02-26",
            "term_of_delivery"=>"2024-02-29"
        ]);
      
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/tasks');
         
        $response->assertStatus(200);

    }

    # php artisan test --filter=AuthControllerTest::test_store_method_creates_new_task
    public function test_store_method_creates_new_task()
    {
        $user = User::factory()->create(['roles' => 'admin']);
        $projectId = Project::withoutEvents(function () {
            return Project::factory()->create()->id;
        });
        $token = $user->createToken('Bearer Token')->plainTextToken;

        $taskData = [
            "title"=> "Projeto Novo",
            "description"=>"Projeto Novo",
            "status"=>"inicio",
            "responsable"=>$user->id,
            "project_id"=>$projectId,
            "start_date"=>"2024-02-26",
            "term_of_delivery"=>"2024-02-29"
        ];
      
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            ])->json('POST', '/api/tasks',$taskData);

     
        
        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Task registered successfully']);


    }

    # php artisan test --filter=AuthControllerTest::test_show_method_returns_specific_task
    public function test_show_method_returns_specific_task()
    {
        $user = User::factory()->create();
        $projectId = Project::withoutEvents(function () {
            return Project::factory()->create()->id;
        });
        $token = $user->createToken('Bearer Token')->plainTextToken;

        $task = Task::create([
            "title"=> "Projeto Novo",
            "description"=>"Projeto Novo",
            "status"=>"inicio",
            "responsable"=>$user->id,
            "project_id"=>$projectId,
            "start_date"=>"2024-02-26",
            "term_of_delivery"=>"2024-02-29"
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/tasks/'.$task->id);
   
        
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $task->id]);
    }

    # php artisan test --filter=AuthControllerTest::test_update_method_updates_existing_task
    public function test_update_method_updates_existing_task()
    {
        $user = User::factory()->create(['roles' => 'admin']);
        $projectId = Project::withoutEvents(function () {
            return Project::factory()->create()->id;
        });
        $task = Task::factory()->create();
        $token = $user->createToken('Bearer Token')->plainTextToken;

        $updatedData = [
            "title"=> "Updated Task Title",
            "description"=>"Fazer alteração no login",
            "status"=>"inicio",
            "responsable"=>$user->id,
            "project_id"=>$projectId ,
            "start_date"=>"2024-02-23",
            "term_of_delivery"=>"2024-02-26"
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('PUT', '/api/tasks/'.$task->id, $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Task Title']);
    }

    # php artisan test --filter=AuthControllerTest::test_destroy_method_deletes_existing_task
    public function test_destroy_method_deletes_existing_task()
    {
        $user = User::factory()->create(['roles' => 'admin']);

        $task = Task::factory()->create();
        $token = $user->createToken('Bearer Token')->plainTextToken;

        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json("DELETE", '/api/tasks/'.$task->id);
       
        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Task deleted successfully']);
    }

}