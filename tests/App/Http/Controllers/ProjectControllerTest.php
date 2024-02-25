<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Testa a listagem de projetos para usuários autenticados.
     *
     * @return void
     */
    public function test_index_projects_for_authenticated_users()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Token Name')->plainTextToken;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/project');
        // $response = $this->actingAs($user, 'sanctum')->get('/project');
        $response->assertStatus(200);
    }

    /**
     * Testa a exibição de um projeto específico para usuários autenticados.
     *
     * @return void
     */
    public function test_show_specific_project_for_authenticated_users()
    {
        $project = Project::factory()->create();
        $response = $this->actingAs(User::factory()->create(), 'sanctum')->get('/project/' . $project->id);
        $response->assertStatus(200);
    }

    /**
     * Testa a criação de um novo projeto para usuários autorizados (admin/manager).
     *
     * @return void
     */
    public function test_create_project_for_authorized_users()
    {
        $user = User::factory()->create(['roles' => 'admin']);
        $projectData = Project::factory()->raw();
        $response = $this->actingAs($user, 'sanctum')->post('/project', $projectData);
        $response->assertStatus(201);
    }

    /**
     * Testa a atualização de um projeto existente para usuários autorizados (admin/manager).
     *
     * @return void
     */
    public function test_update_existing_project_for_authorized_users()
    {
        $user = User::factory()->create(['roles' => 'manager']);
        $project = Project::factory()->create();
        $updatedData = ['title' => 'Updated Title', 'description' => 'Updated Description'];
        $response = $this->actingAs($user, 'sanctum')->put('/project/' . $project->id, $updatedData);
        $response->assertStatus(200);
    }

    /**
     * Testa a exclusão de um projeto existente para usuários autorizados (admin/manager).
     *
     * @return void
     */
    public function test_delete_existing_project_for_authorized_users()
    {
        $user = User::factory()->create(['roles' => 'admin']);
        $project = Project::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->delete('/project/' . $project->id);
        $response->assertStatus(200);
    }

    /**
     * Testa a listagem de projetos de um usuário específico para usuários autenticados.
     *
     * @return void
     */
    public function test_index_user_projects_for_authenticated_users()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->get('/projectsusers');
        $response->assertStatus(200);
    }

    /**
     * Testa a listagem de projetos de um usuário específico para usuários autenticados.
     *
     * @return void
     */
    public function test_show_user_projects_for_authenticated_users()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->get('/projectsusers/' . $project->id);
        $response->assertStatus(200);
    }
}
