<?php

namespace Tests\Feature;

use App\Http\Controllers\ProjectController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\JWTAuth;
use Mockery;

class ProjectControllerTest extends TestCase
{
    use DatabaseTransactions;
    public function test_index_projects_for_authenticated_users()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->get('/project');
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
        $response->assertStatus(Response::HTTP_OK);
    }
    public function test_create_project_for_authorized_users()
    {
        $user = User::factory()->create(['roles' => 'admin']);
        $projectData = Project::factory()->raw();
        $response = $this->actingAs($user, 'sanctum')->post('/project', $projectData);
        $response->assertStatus(201);
    }
    

    public function testStoreProjectSuccessForManager()
    {
        $user = User::factory()->create(['roles' => 'manager']);
        $data = [
            "title"=> "Projeto Novo",
            "description"=>"Projeto Novo",
            "start_date"=>"2024-02-23",
            "term_of_delivery"=>"2024-02-26"
        ];
       
        $token = $user->createToken('Bearer Token', ['expires_in' => 10080])->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];

        $response = $this->actingAs($user, 'api')
            ->withHeaders($headers)
            ->json('POST','/api/project', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message' => 'Project registered successfully',
            ]);

        $this->assertDatabaseHas('projects', $data); // Note a mudança aqui
    }

    public function testStoreProjectFailsForUnauthorizedUser()
    {
        $user = User::factory()->create();
        $data = [
            'title' => 'My New Project',
            'description' => 'This is my new project description.',
        ];

        $token = $user->createToken('Bearer Token', ['expires_in' => 10080])->plainTextToken;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];

        $response = $this->actingAs($user, 'api')
            ->withHeaders($headers)
            ->postJson('/project', $data);
        // ... continuação do método testStoreProjectFailsForUnauthorizedUser
        $response->assertStatus(403)
            ->assertJson(['error' => 'Acesso não autorizado']);
    }

    public function testIndexProjectSuccessForAdmin()
    {
        $user = User::factory()->create(['roles' => 'admin']);
        
        // Use Sequence to ensure that the created projects have unique data
        $projects = Project::factory()
            ->count(5)
            ->state(new Sequence(
                ['title' => 'Project 1'],
                ['title' => 'Project 2'],
                ['title' => 'Project 3'],
                ['title' => 'Project 4'],
                ['title' => 'Project 5'],
            ))
            ->create();
    
        $token = $user->createToken('Bearer Token', ['expires_in' => 10080])->plainTextToken;
    
        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];
    
        $response = $this->actingAs($user, 'api')
            ->withHeaders($headers)
            ->getJson('/project');
    
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'description',
                    'start_date',
                    'term_of_delivery',
                    'created_at',
                    'updated_at',
                ],
            ]);
    
        $response->json()->shouldHaveCount(5);
    }
    
}

        
