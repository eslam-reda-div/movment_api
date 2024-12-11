<?php

namespace App\Filament\Company\Widgets;

use App\Enums\TripStatus;
use App\Models\Trip;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TodayTrips extends BaseWidget
{
    protected static ?string $title = null;

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 100;

    public function getTableHeading(): string
    {
        return __('dashboard::dashboard.today_trips.title');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Trip::query()
                    ->where('company_id', auth('company')->id())
                    ->whereDate('start_at_day', today())
                    ->orderBy('start_at_time')
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('dashboard::dashboard.today_trips.table.id'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_at_day')
                    ->label(__('dashboard::dashboard.today_trips.table.start_at_day'))
                    ->sortable()
                    ->date('Y-m-d')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_at_time')
                    ->label(__('dashboard::dashboard.today_trips.table.start_at_time'))
                    ->sortable()
                    ->time('g:i a')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('dashboard::dashboard.today_trips.table.status'))
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->badge()
                    ->color(fn (Trip $record): string => match ($record->status) {
                        TripStatus::SCHEDULED->value => 'warning',
                        TripStatus::IN_PROGRESS->value => 'info',
                        TripStatus::COMPLETED->value => 'success',
                    }),
                Tables\Columns\TextColumn::make('path.domain.name')
                    ->label(__('dashboard::dashboard.today_trips.table.domain'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('path.fromDestination.name')
                    ->label(__('dashboard::dashboard.today_trips.table.from'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('path.stops')
                    ->label(__('dashboard::dashboard.today_trips.table.stops'))
                    ->badge()
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->state(function (Trip $record) {
                        $stops = $record?->path?->stops;

                        if (! $stops) {
                            return '';
                        }

                        return collect($stops)
                            ->pluck('destination_id')
                            ->map(function ($destinationId) {
                                return \App\Models\Destination::find($destinationId)?->name ?? '';
                            })
                            ->filter();
                    }),
                Tables\Columns\TextColumn::make('path.toDestination.name')
                    ->label(__('dashboard::dashboard.today_trips.table.to'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('driver.avatar_url')
                    ->label(__('dashboard::dashboard.today_trips.table.driver_avatar'))
                    ->toggleable()
                    ->defaultImageUrl(url('https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&r=g&s=250'))
                    ->circular(),
                Tables\Columns\TextColumn::make('driver.name')
                    ->label(__('dashboard::dashboard.today_trips.table.driver_name'))
                    ->description(fn (Trip $record) => $record->driver?->notes)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('driver.phone_number')
                    ->label(__('dashboard::dashboard.today_trips.table.driver_phone'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('driver.bus.image_url')
                    ->label(__('dashboard::dashboard.today_trips.table.bus_image'))
                    ->toggleable()
                    ->defaultImageUrl(url('https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&r=g&s=250')),
                Tables\Columns\TextColumn::make('driver.bus.number')
                    ->label(__('dashboard::dashboard.today_trips.table.bus_number'))
                    ->description(fn (Trip $record) => $record->driver?->bus ? "{$record->driver?->bus?->name} - {$record->driver?->bus->notes}".($record->driver?->bus->is_active ? ' (Active)' : ' (Inactive)') : null)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('driver.bus.seats_count')
                    ->label(__('dashboard::dashboard.today_trips.table.bus_seats'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
            ]);
    }
}
