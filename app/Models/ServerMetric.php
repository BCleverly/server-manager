<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $site_id
 * @property string $type
 * @property string $value
 * @property \Carbon\Carbon $collected_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class ServerMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'type',
        'value',
        'collected_at',
    ];

    protected $dates = [
        'collected_at',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
