<?php

namespace App\Filament\Resources\PropertyResource\Widgets;

use App\Models\Property;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PropertyWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(label: 'Total properties',value: Property::count())
        ];
    }
}
