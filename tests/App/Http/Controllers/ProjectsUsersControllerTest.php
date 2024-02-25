<?php

namespace Tests\Feature;

use App\Models\UserProject;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsUsersControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_index_method_returns_all_user_projects()
    {
        UserProject::factory()->count(3)->create();

        $response = $this->get('/projects_users');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_store_method_creates_new_user_project()
    {
        $userProjectData = [
            "user_id" => 1,
            "project_id" => 1,
            // Add other required fields as needed
        ];

        $response = $this->post('/projects_users', $userProjectData);

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'User successfully introduced into the project']);
    }

    public function test_show_method_returns_specific_user_project()
    {
        $userProject = UserProject::factory()->create();

        $response = $this->get("/projects_users/{$userProject->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $userProject->id]);
    }

    public function test_update_method_updates_existing_user_project()
    {
        $userProject = UserProject::factory()->create();

        $updatedData = [
            "user_id" => 2,
            "project_id" => 2,
            // Add other fields as needed
        ];

        $response = $this->put("/projects_users/{$userProject->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment(['user_id' => 2]);
    }

    public function test_destroy_method_deletes_existing_user_project()
    {
        $userProject = UserProject::factory()->create();

        $response = $this->delete("/projects_users/{$userProject->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Association dissolved']);
    }
}
