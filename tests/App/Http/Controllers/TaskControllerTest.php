<?php

namespace Tests\App;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;

class TaskControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_index_method_returns_all_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->get('api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_store_method_creates_new_task()
    {
        $taskData = [
            "title"=> "Nova Task",
            "description"=>"Fazer alteração no login",
            "status"=>"inicio",
            "responsable"=>1,//
            "project_id"=>1,
            "start_date"=>"2024-02-23",
            "term_of_delivery"=>"2024-02-26"
        ];
        $response = $this->call('POST','api/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Task registered successfully']);
    }

    public function test_show_method_returns_specific_task()
    {
        $task = Task::factory()->create();

        $response = $this->get("api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $task->id]);
    }

    public function test_update_method_updates_existing_task()
    {
        $task = Task::factory()->create();

        $updatedData = [
            "title"=> "Nova Task",
            "description"=>"Fazer alteração no login",
            "status"=>"inicio",
            "responsable"=>1,
            "project_id"=>1,
            "start_date"=>"2024-02-23",
            "term_of_delivery"=>"2024-02-26"
        ];

        $response = $this->put("api/tasks/{$task->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Task Title']);
    }

    public function test_destroy_method_deletes_existing_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete("api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Task deleted successfully']);
    }

}