<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

use App\Models\Project;
use App\Models\User;
use App\Models\UserProject;

use Illuminate\Support\Facades\Auth;

class ProjectControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Testa a listagem de projetos para usuários autenticados.
     *
     * @return void
     */

    # php artisan test --filter=AuthControllerTest::test_index_projects_for_authenticated_users
    public function test_index_projects_for_authenticated_users()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Token Name')->plainTextToken;
    
        Project::withoutEvents(function () {
            Project::create([
                "title"=> "Projeto Novo",
                "description"=>"Projeto Novo",
                "start_date"=>"2024-02-23",
                "term_of_delivery"=>"2024-02-26"
            ]);
        });
       
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/project');

        
        // $response = $this->actingAs($user, 'sanctum')->get('/project');
        $response->assertStatus(200);
    }

    /**
     * Testa a exibição de um projeto específico para usuários autenticados.
     *
     * @return void
     */
   
    # php artisan test --filter=AuthControllerTest::test_show_specific_project_for_authenticated_users
    public function test_show_specific_project_for_authenticated_users()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Token Name')->plainTextToken;
    
        $project = Project::withoutEvents(function () {
            return  Project::create([
                "title"=> "Projeto Novo",
                "description"=>"Projeto Novo",
                "start_date"=>"2024-02-23",
                "term_of_delivery"=>"2024-02-26"
            ]);
        });
       
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/project/'. $project->id);

        $response->assertStatus(200)    
            ->assertJsonFragment(['id' => $project->id]);
    }

    /**
     * Testa a criação de um novo projeto para usuários autorizados (admin/manager).
     *
     * @return void
     */


    # php artisan test --filter=AuthControllerTest::test_create_project_for_authorized_users
    public function test_create_project_for_authorized_users()
    {
        $user = User::factory()->create(['roles' => 'admin']);
        $token = $user->createToken('Token Name')->plainTextToken;
    
        $projectData =   $project =[
            "title"=> "Projeto Novo",
            "description"=>"Projeto Novo",
            "start_date"=>"2024-02-23",
            "term_of_delivery"=>"2024-02-26"
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', '/api/project/', $projectData);
       
        $response->assertStatus(201);
    }

    /**
     * Testa a atualização de um projeto existente para usuários autorizados (admin/manager).
     *
     * @return void
     */

    # php artisan test --filter=AuthControllerTest::test_update_existing_project_for_authorized_users
    public function test_update_existing_project_for_authorized_users()
    {
        $user = User::factory()->create(['roles' => 'dev']);
        $token = $user->createToken('Token Name')->plainTextToken;
    
        $projectData =   $project =[
            "title"=> "Projeto Novo",
            "description"=>"Projeto Novo",
            "start_date"=>"2024-02-23",
            "term_of_delivery"=>"2024-02-26"
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', '/api/project/', $projectData);
       
        $response->assertStatus(403);
    }

    /**
     * Testa a exclusão de um projeto existente para usuários autorizados (admin/manager).
     *
     * @return void
     */

    # php artisan test --filter=AuthControllerTest::test_delete_existing_project_for_authorized_users
    public function test_delete_existing_project_for_authorized_users()
    {
        $user = User::factory()->create(['roles'=>'manager']);
        $token = $user->createToken('Token Name')->plainTextToken;
    
        $project = Project::withoutEvents(function () {
            return  Project::create([
                "title"=> "Projeto Novo",
                "description"=>"Projeto Novo",
                "start_date"=>"2024-02-23",
                "term_of_delivery"=>"2024-02-26"
            ]);
        });
       
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('DELETE', '/api/project/'. $project->id);

        $response->assertStatus(200);
    }

    /**
     * Testa a listagem de projetos de um usuário específico para usuários autenticados.
     *
     * @return void
     */

    # php artisan test --filter=AuthControllerTest::test_index_user_projects_for_authenticated_users
    public function test_index_user_projects_for_authenticated_users()
    {
        $user = User::factory()->create(['roles'=>'manager']);
        $token = $user->createToken('Token Name')->plainTextToken;
  
        $project = Project::withoutEvents(function () {
            return  Project::create([
                "title"=> "Projeto Novo",
                "description"=>"Projeto Novo",
                "start_date"=>"2024-02-23",
                "term_of_delivery"=>"2024-02-26"
            ]);
        });

        //Alocando usuarios a um projeto
        UserProject::create([
            "users_id"=> $user->id,
            "project_id"=>$project->id, 
        ]);
       
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/projectsusers');
        
        $response->assertStatus(200);
    }

    /**
     * Testa a listagem de projetos de um usuário específico para usuários autenticados.
     *
     * @return void
     */

    # php artisan test --filter=AuthControllerTest::test_show_user_projects_for_authenticated_users
    public function test_show_user_projects_for_authenticated_users()
    {
        $user = User::factory()->create(['roles'=>'manager']);
        $token = $user->createToken('Token Name')->plainTextToken;
  
        $project = Project::withoutEvents(function () {
            return  Project::create([
                "title"=> "Projeto Novo",
                "description"=>"Projeto Novo",
                "start_date"=>"2024-02-23",
                "term_of_delivery"=>"2024-02-26"
            ]);
        });

        //Alocando usuarios a um projeto
        UserProject::create([
            "users_id"=> $user->id,
            "project_id"=>$project->id, 
        ]);
       
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/projectsusers/'.$project->id);
        
        $response->assertStatus(200);
    }
}
