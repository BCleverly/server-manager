<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Site>
 */
class SiteFactory extends Factory
{
    protected $model = Site::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->company.' Site',
            'domain' => $this->faker->unique()->domainName,
            'folder' => $this->faker->slug(2),
            'php_version' => $this->faker->randomElement(['8.1', '8.2', '8.3']),
            'repository' => $this->faker->optional()->url,
            'repository_branch' => $this->faker->optional()->randomElement(['main', 'master', 'develop']),
        ];
    }
}
