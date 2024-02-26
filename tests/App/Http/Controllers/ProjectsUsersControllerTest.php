<?php

namespace Tests\Feature;

use App\Models\UserProject;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;



class ProjectsUsersControllerTest extends TestCase
{
    use DatabaseTransactions;

    # php artisan test --filter=AuthControllerTest::test_index_method_returns_all_user_projects
    public function test_index_method_returns_all_user_projects()
    {

        $user = User::factory()->create();
        $projectId = Project::withoutEvents(function () {
            return Project::factory()->create()->id;
        });
        $token = $user->createToken('Bearer Token')->plainTextToken;

         //Alocando usuarios a um projeto
        UserProject::create([
            "users_id"=> $user->id,
            "project_id"=>$projectId
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/project_user');
   
        $response->assertStatus(200);

    }

    # php artisan test --filter=AuthControllerTest::test_store_method_creates_new_user_project
    public function test_store_method_creates_new_user_project()
    {
        $user = User::factory()->create(["roles"=>"admin"]);

        $projectId = Project::withoutEvents(function () {
            return Project::factory()->create()->id;
        });

        $token = $user->createToken('Bearer Token')->plainTextToken;

        $userProjectData = [
            "users_id" =>  $user->id,
            "project_id" => $projectId,
            // Add other required fields as needed
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', '/api/project_user',$userProjectData);
   //dd( $response);
        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'User successfully introduced into the project']);
    }

    # php artisan test --filter=AuthControllerTest::test_show_method_returns_specific_user_project
    public function test_show_method_returns_specific_user_project()
    {
        $user = User::factory()->create();
        $projectId = Project::withoutEvents(function () {
            return Project::factory()->create()->id;
        });
        $token = $user->createToken('Bearer Token')->plainTextToken;

         //Alocando usuarios a um projeto
        $projectuser = UserProject::create([
            "users_id"=> $user->id,
            "project_id"=>$projectId
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', '/api/project_user/'.$projectuser->id);
       
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $projectuser->id]);
    }
    
    # php artisan test --filter=AuthControllerTest::test_update_method_updates_existing_user_project
    public function test_update_method_updates_existing_user_project()
    {
        $userProject = UserProject::factory()->create();
        $user = User::factory()->create(['roles'=>'techleader']);

        $token = $user->createToken('Bearer Token')->plainTextToken;

        $projectId = Project::withoutEvents(function () {
            return Project::factory()->create()->id;
        });
        $updatedData = [
                "users_id"=> $user->id,
                "project_id"=>$projectId
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('PUT', '/api/project_user/'.$userProject ->id, $updatedData);
      
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $userProject ->id]);
    }

    # php artisan test --filter=AuthControllerTest::test_destroy_method_deletes_existing_user_project
    public function test_destroy_method_deletes_existing_user_project()
    {
        $user = User::factory()->create(['roles'=>'techleader']);
        $projectId = Project::withoutEvents(function () {
            return Project::factory()->create()->id;
        });
        $token = $user->createToken('Bearer Token')->plainTextToken;

         //Alocando usuarios a um projeto
        $userProject = UserProject::create([
            "users_id"=> $user->id,
            "project_id"=>$projectId
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('DELETE', '/api/project_user/'.$userProject ->id);
      
        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Association dissolved']);
    }
}
