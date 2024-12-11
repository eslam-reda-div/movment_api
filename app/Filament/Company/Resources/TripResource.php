<?php

namespace App\Filament\Company\Resources;

use App\Enums\TripStatus;
use App\Filament\Company\Resources\TripResource\Pages;
use App\Models\Driver;
use App\Models\Path;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use HusamTariq\FilamentTimePicker\Forms\Components\TimePickerField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static ?string $navigationIcon = 'entypo-location';

    protected static ?string $recordTitleAttribute = 'path.name';

    public static function getModelLabel(): string
    {
        return __('dashboard::dashboard.resource.com_trip.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard::dashboard.resource.com_trip.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.resource.com_trip.navigation.group');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'path.name',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('dashboard::dashboard.resource.com_trip.messages.search.path_name') => $record?->path?->name,
            __('dashboard::dashboard.resource.com_trip.messages.search.driver_name') => $record?->driver->name,
            __('dashboard::dashboard.resource.com_trip.messages.search.trip_date') => $record?->start_at_day ? date('Y-m-d', strtotime($record->start_at_day)) : null,
            __('dashboard::dashboard.resource.com_trip.messages.search.trip_time') => $record?->start_at_time ? date('g:i a', strtotime($record->start_at_time)) : null,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('company_id', auth('company')->id())
            ->orderBy('start_at_day', 'desc')
            ->orderBy('start_at_time', 'desc');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('company_id', auth('company')->id())->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\DatePicker::make('start_at_day')
                            ->label(__('dashboard::dashboard.resource.com_trip.form.start_at_day'))
                            ->columnSpan('full')
                            ->default(now())
                            ->minDate(now()->subDays(1))
                            ->format('Y-m-d')
                            ->seconds(false)
                            ->native(false)
                            ->required(),
                        TimePickerField::make('start_at_time')
                            ->label(__('dashboard::dashboard.resource.com_trip.form.start_at_time'))
                            ->required()
                            ->columnSpan('full')
                            ->okLabel(__('dashboard::dashboard.resource.com_trip.form.time_picker.confirm'))
                            ->cancelLabel(__('dashboard::dashboard.resource.com_trip.form.time_picker.cancel')),
                        Forms\Components\Select::make('driver_id')
                            ->label(__('dashboard::dashboard.resource.com_trip.form.driver'))
                            ->required()
                            ->relationship('driver', 'name')
                            ->columnSpan('full')
                            ->options(function () {
                                return Driver::where('company_id', auth('company')->id())
                                    ->whereHas('bus')
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Forms\Components\Select::make('path_id')
                            ->label(__('dashboard::dashboard.resource.com_trip.form.path'))
                            ->relationship('path', 'name')
                            ->columnSpan('full')
                            ->required()
                            ->options(function () {
                                return Path::where('company_id', auth('company')->id())
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Forms\Components\Select::make('status')
                            ->label(__('dashboard::dashboard.resource.com_trip.form.status'))
                            ->required()
                            ->columnSpan('full')
                            ->options([
                                TripStatus::SCHEDULED->value => __('dashboard::dashboard.resource.com_trip.form.status_options.scheduled'),
                                TripStatus::IN_PROGRESS->value => __('dashboard::dashboard.resource.com_trip.form.status_options.in_progress'),
                                TripStatus::COMPLETED->value => __('dashboard::dashboard.resource.com_trip.form.status_options.completed'),
                            ])
                            ->default(TripStatus::SCHEDULED->value)
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->hidden(fn (string $context): bool => $context === 'create')
                            ->disabled(fn (string $context): bool => $context === 'create'),
                        Forms\Components\Textarea::make('notes')
                            ->label(__('dashboard::dashboard.resource.com_trip.form.notes'))
                            ->columnSpan('full'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.id'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_at_day')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.start_at_day'))
                    ->sortable()
                    ->toggleable()
                    ->date('Y-m-d')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_at_time')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.start_at_time'))
                    ->sortable()
                    ->time('g:i a')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.status'))
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        TripStatus::SCHEDULED->value => __('dashboard::dashboard.resource.com_trip.status.scheduled'),
                        TripStatus::IN_PROGRESS->value => __('dashboard::dashboard.resource.com_trip.status.in_progress'),
                        TripStatus::COMPLETED->value => __('dashboard::dashboard.resource.com_trip.status.completed'),
                        default => $state,
                    })
                    ->color(fn (Trip $record): string => match ($record->status) {
                        TripStatus::SCHEDULED->value => 'warning',
                        TripStatus::IN_PROGRESS->value => 'info',
                        TripStatus::COMPLETED->value => 'success',
                    }),
                Tables\Columns\TextColumn::make('path.domain.name')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.domain'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('path.fromDestination.name')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.from'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('path.stops')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.stops'))
                    ->badge()
                    ->sortable()
                    ->toggleable()
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
                    ->label(__('dashboard::dashboard.resource.com_trip.table.to'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('driver.avatar_url')
                    ->toggleable()
                    ->label(__('dashboard::dashboard.resource.com_trip.table.driver_avatar'))
                    ->defaultImageUrl(url('https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&r=g&s=250'))
                    ->circular(),
                Tables\Columns\TextColumn::make('driver.name')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.driver_name'))
                    ->description(fn (Trip $record) => $record->driver?->notes)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('driver.phone_number')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.driver_phone'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('driver.bus.image_url')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.bus_image'))
                    ->toggleable()
                    ->defaultImageUrl(url('https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&r=g&s=250')),
                Tables\Columns\TextColumn::make('driver.bus.number')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.bus_number'))
                    ->description(fn (Trip $record) => $record->driver?->bus ? "{$record->driver?->bus?->name} - {$record->driver?->bus->notes}".($record->driver?->bus->is_active ? ' (Active)' : ' (Inactive)') : null)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('driver.bus.seats_count')
                    ->label(__('dashboard::dashboard.resource.com_trip.table.bus_seats'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label(__('dashboard::dashboard.resource.com_trip.actions.edit')),
                    Tables\Actions\DeleteAction::make()
                        ->label(__('dashboard::dashboard.resource.com_trip.actions.delete')),
                ])->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('primary')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('dashboard::dashboard.resource.com_trip.actions.bulk_delete')),
                ]),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('dashboard::dashboard.resource.com_trip.actions.create')),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}
