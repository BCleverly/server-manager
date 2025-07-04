<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\DnsRecord;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DnsRecord>
 */
class DnsRecordFactory extends Factory
{
    protected $model = DnsRecord::class;

    public function definition(): array
    {
        return [
            'site_id' => Site::factory(),
            'type' => $this->faker->randomElement(['A', 'CNAME', 'MX', 'TXT']),
            'name' => $this->faker->domainWord,
            'value' => $this->faker->ipv4,
            'ttl' => $this->faker->numberBetween(300, 86400),
        ];
    }
}
