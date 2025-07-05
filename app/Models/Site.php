<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $domain
 * @property string $php_version
 * @property string|null $repository
 * @property string|null $repository_branch
 * @property bool $letsencrypt_https_enabled
 * @property string $folder
 * @property string|null $deployment_status
 * @property string|null $deployment_log
 * @property array|null $dns_records
 * @property array|null $server_metrics
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Site extends Model
{
    use HasFactory;

    protected $casts = [
        'letsencrypt_https_enabled' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'domain',
        'php_version',
        'repository',
        'repository_branch',
        'letsencrypt_https_enabled',
        'folder',
    ];

    /**
     * Get the user that owns the site.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the DNS records for the site.
     */
    public function dnsRecords(): HasMany
    {
        return $this->hasMany(DnsRecord::class);
    }

    /**
     * Get the deployments for the site.
     */
    public function deployments(): HasMany
    {
        return $this->hasMany(Deployment::class);
    }

    /**
     * Get the server metrics for the site.
     */
    public function serverMetrics(): HasMany
    {
        return $this->hasMany(ServerMetric::class);
    }

    /**
     * Check if Let's Encrypt HTTPS is enabled for this site.
     */
    public function hasLetsEncryptHttps(): bool
    {
        return $this->letsencrypt_https_enabled;
    }

    /**
     * Enable Let's Encrypt HTTPS for this site.
     */
    public function enableLetsEncryptHttps(): void
    {
        $this->update(['letsencrypt_https_enabled' => true]);
    }

    /**
     * Disable Let's Encrypt HTTPS for this site.
     */
    public function disableLetsEncryptHttps(): void
    {
        $this->update(['letsencrypt_https_enabled' => false]);
    }
}
