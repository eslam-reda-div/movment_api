<?php

namespace App\Filament\Admin\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Widget;

class ServerStorageWidget extends Widget
{
    use HasWidgetShield;

    protected static string $view = 'filament.admin.widgets.server-storage-widget';

    protected static ?int $sort = 93;

    protected int|string|array $columnSpan = 'full';

    public function getFillColor(): string
    {
        $percentageUsed = $this->getStorageInfo()['percentage_used'];

        if ($percentageUsed < 50) {
            return 'green';
        }

        if ($percentageUsed < 80) {
            return 'yellow';
        }

        return 'red';
    }

    public function getStorageInfo(): array
    {
        $totalSpace = disk_total_space('/');
        $freeSpace = disk_free_space('/');
        $usedSpace = $totalSpace - $freeSpace;

        return [
            'total' => $this->formatBytes($totalSpace),
            'free' => $this->formatBytes($freeSpace),
            'used' => $this->formatBytes($usedSpace),
            'percentage_used' => round(($usedSpace / $totalSpace) * 100, 2),
        ];
    }

    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision).' '.$units[$pow];
    }
}
