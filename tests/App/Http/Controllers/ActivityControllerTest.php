<?php

namespace Tests\Feature;

use App\Models\Activity;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_index_method_returns_all_activities()
    {
        Activity::factory()->count(3)->create();

        $response = $this->get('api/activities');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_store_method_creates_new_activity()
    {
        $activityData = [
            "name" => "New Activity",
            "description" => "Description of the new activity"
            // Add other required fields as needed
        ];

        $response = $this->post('/activities', $activityData);

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Activity registered successfully']);
    }

    public function test_show_method_returns_specific_activity()
    {
        $activity = Activity::factory()->create();

        $response = $this->get("/activities/{$activity->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $activity->id]);
    }

    public function test_update_method_updates_existing_activity()
    {
        $activity = Activity::factory()->create();

        $updatedData = [
            "name" => "Updated Activity Name",
            "description" => "Updated activity description"
            // Add other fields as needed
        ];

        $response = $this->put("/activities/{$activity->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Activity Name']);
    }

    public function test_destroy_method_deletes_existing_activity()
    {
        $activity = Activity::factory()->create();

        $response = $this->delete("/activities/{$activity->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Activity deleted successfully']);
    }
}
