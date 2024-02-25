<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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
            "start_date"=>"2024-02-26",
            "term_of_delivery"=>"2024-02-29"
        ];
    }
}
