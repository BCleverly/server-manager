<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $site_id
 * @property string $status
 * @property string|null $log
 * @property \Carbon\Carbon|null $started_at
 * @property \Carbon\Carbon|null $finished_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Deployment extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'status',
        'log',
        'started_at',
        'finished_at',
    ];

    protected $dates = [
        'started_at',
        'finished_at',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
