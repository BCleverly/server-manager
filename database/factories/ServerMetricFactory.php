<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ServerMetric;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServerMetric>
 */
class ServerMetricFactory extends Factory
{
    protected $model = ServerMetric::class;

    public function definition(): array
    {
        return [
            'site_id' => Site::factory(),
            'type' => $this->faker->randomElement(['cpu', 'ram', 'disk', 'network', 'php-fpm']),
            'value' => (string) $this->faker->randomFloat(2, 0, 100),
            'collected_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
        ];
    }
}
