<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Deployment;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Deployment>
 */
class DeploymentFactory extends Factory
{
    protected $model = Deployment::class;

    public function definition(): array
    {
        $started = $this->faker->dateTimeBetween('-1 week', 'now');
        $finished = $this->faker->boolean(80) ? $this->faker->dateTimeBetween($started, 'now') : null;

        return [
            'site_id' => Site::factory(),
            'status' => $this->faker->randomElement(['pending', 'running', 'success', 'failed']),
            'log' => $this->faker->optional()->text(200),
            'started_at' => $started,
            'finished_at' => $finished,
        ];
    }
}
