<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions; // Isso reinicializa o banco de dados após cada teste

    public function test_user_registration()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ];

        $response = $this->json('POST', '/api/register', $userData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'User registered successfully!'
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com'
        ]);
    }

    public function test_user_login()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('1234567'),
        ]);

        $loginData = [
            'email' => 'john@example.com',
            'password' => '1234567',
        ];

        $response = $this->json('POST', '/api/login', $loginData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'name',
                'token'
            ]);
    }

    public function test_user_logout()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '1234567',
        ]);
        
        $loginData = [
            'email' => $user->email,
            'password' => '1234567'
        ];
    
        $login = $this->json('POST', '/api/login', $loginData);
        $loginToken = $login['token']; // Supondo que o token seja retornado na resposta
    
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $loginToken,
        ])->json('POST', '/api/logout');
            
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Logout successful!'
            ]);
    }
    
}
