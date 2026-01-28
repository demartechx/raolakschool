<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Enrollment;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Registered Users', \App\Models\User::count())
                ->description('Total users on the platform')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Programming Students', Enrollment::where('course', 'Programming')->count())
                ->description('Total registered for Programming')
                ->descriptionIcon('heroicon-m-code-bracket')
                ->color('info'),

            Stat::make('Graphics Design Students', Enrollment::where('course', 'Graphics Design')->count())
                ->description('Total registered for Graphics Design')
                ->descriptionIcon('heroicon-m-paint-brush')
                ->color('warning'),

            Stat::make('Admitted Students', Enrollment::where('status', 'admitted')->count())
                ->description('Total students admitted')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
