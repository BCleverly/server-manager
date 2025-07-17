<?php

declare(strict_types=1);

namespace App\Services;

class ServerStatsService
{
    public function getStats(): array
    {
        $cpu = $this->getCpuUsage();
        $memory = $this->getMemoryUsage();
        $load = $this->getLoadAverage();

        return [
            'cpu' => $cpu,
            'memory' => $memory,
            'load' => $load,
            'updated_at' => now()->toIso8601String(),
        ];
    }

    protected function getCpuUsage(): ?float
    {
        if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
            // Windows: not implemented
            return null;
        }
        $load = sys_getloadavg();
        if ($load && isset($load[0])) {
            return round($load[0] * 100 / (int) shell_exec('nproc'), 2);
        }
        return null;
    }

    protected function getMemoryUsage(): ?float
    {
        if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
            // Windows: not implemented
            return null;
        }
        $meminfo = @file_get_contents('/proc/meminfo');
        if ($meminfo) {
            preg_match('/MemTotal:\s+(\d+)/', $meminfo, $total);
            preg_match('/MemAvailable:\s+(\d+)/', $meminfo, $available);
            if (isset($total[1], $available[1])) {
                $used = ((int)$total[1] - (int)$available[1]) / 1024;
                return round($used, 2);
            }
        }
        return null;
    }

    protected function getLoadAverage(): ?string
    {
        if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
            return null;
        }
        $load = sys_getloadavg();
        if ($load) {
            return implode(', ', array_map(fn($v) => round($v, 2), $load));
        }
        return null;
    }
} 