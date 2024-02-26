<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title"=> "Projeto Novo",
            "description"=>"Projeto Novo",
            "status"=>"inicio",
            "responsable"=>User::factory()->create(),
            "project_id"=>Project::withoutEvents(function () {
                return Project::factory()->create()->id;
            }),
            "start_date"=>"2024-02-26",
            "term_of_delivery"=>"2024-02-29"
        ];
    }
}
