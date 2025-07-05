<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReverbConnectivityService
{
    public function isReverbAvailable(): bool
    {
        try {
            $host = config('broadcasting.connections.reverb.options.host');
            $port = config('broadcasting.connections.reverb.options.port');
            $scheme = config('broadcasting.connections.reverb.options.scheme', 'https');
            
            // If no host is configured, assume localhost
            if (empty($host)) {
                $host = 'localhost';
            }
            
            $url = "{$scheme}://{$host}:{$port}";
            
            // Try to make a simple HTTP request to check if Reverb is responding
            $response = Http::timeout(5)->get($url);
            
            // If we get any response (even an error), the server is reachable
            return $response->status() > 0;
            
        } catch (\Exception $e) {
            Log::warning('Reverb connectivity check failed', [
                'error' => $e->getMessage(),
                'host' => $host ?? 'not configured',
                'port' => $port ?? 'not configured'
            ]);
            
            return false;
        }
    }
    
    public function getReverbStatus(): array
    {
        $isAvailable = $this->isReverbAvailable();
        
        return [
            'available' => $isAvailable,
            'message' => $isAvailable 
                ? 'Reverb is connected and working properly'
                : 'Reverb is currently not available. Real-time features may not work.',
            'config' => [
                'host' => config('broadcasting.connections.reverb.options.host'),
                'port' => config('broadcasting.connections.reverb.options.port'),
                'scheme' => config('broadcasting.connections.reverb.options.scheme'),
                'driver' => config('broadcasting.default'),
            ]
        ];
    }
} 