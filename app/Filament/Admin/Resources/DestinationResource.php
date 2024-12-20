<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DestinationResource\Pages;
use App\Models\Destination;
use App\Models\Domain;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DestinationResource extends Resource
{
    protected static ?string $model = Destination::class;

    protected static ?string $navigationIcon = 'fas-location-crosshairs';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('dashboard::dashboard.resource.destination.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard::dashboard.resource.destination.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.resource.destination.navigation.group');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('dashboard::dashboard.resource.destination.messages.search.name') => $record?->name,
            __('dashboard::dashboard.resource.destination.messages.search.domain') => $record?->domain?->name,
            __('dashboard::dashboard.resource.destination.messages.search.path_count') => $record?->paths->count(),
            __('dashboard::dashboard.resource.destination.messages.search.paths_from_count') => $record?->pathsFrom->count(),
            __('dashboard::dashboard.resource.destination.messages.search.paths_to_count') => $record?->pathsTo->count(),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('dashboard::dashboard.resource.destination.form.name'))
                            ->columnSpan('full')
                            ->required(),

                        Forms\Components\Select::make('domain_id')
                            ->label(__('dashboard::dashboard.resource.destination.form.domain'))
                            ->relationship('domain', 'name')
                            ->columnSpan('full')
                            ->required()
                            ->options(function () {
                                return Domain::all()->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->native(false),

                        \Dotswan\MapPicker\Fields\Map::make('location')
                            ->label(__('dashboard::dashboard.resource.destination.form.location'))
                            ->columnSpan('full')
                            ->extraStyles([
                                'min-height: 80vh',
                            ])
                            ->showMarker()
                            ->markerColor('#2563EB')
                            ->required()
                            ->showFullscreenControl()
                            ->showZoomControl()
                            ->draggable()
                            ->tilesUrl(env('TILES_URL', 'https://tile.openstreetmap.de/{z}/{x}/{y}.png'))
                            ->zoom(15)
                            ->showMyLocationButton()
                            ->geoMan(true)
                            ->geoManEditable(true)
                            ->geoManPosition('topleft')
                            ->drawPolygon()
                            ->drawCircle()
                            ->dragMode()
                            ->editPolygon()
                            ->deleteLayer()
                            ->setColor('#3388ff')
                            ->setFilledColor('#cad9ec'),

                        Forms\Components\Textarea::make('notes')
                            ->label(__('dashboard::dashboard.resource.destination.form.notes'))
                            ->columnSpan('full'),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('dashboard::dashboard.resource.destination.form.is_active'))
                            ->default(true)
                            ->inline(false)
                            ->onColor('success')
                            ->offColor('danger')
                            ->columnSpan('full'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('dashboard::dashboard.resource.destination.table.id'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('dashboard::dashboard.resource.destination.table.name'))
                    ->description(fn (Destination $record) => $record?->notes)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('domain.name')
                    ->label(__('dashboard::dashboard.resource.destination.table.domain'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('dashboard::dashboard.resource.destination.table.is_active'))
                    ->onColor('success')
                    ->toggleable()
                    ->offColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dashboard::dashboard.resource.destination.table.created_at'))
                    ->date()
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label(__('dashboard::dashboard.resource.destination.actions.edit')),
                    Tables\Actions\DeleteAction::make()
                        ->label(__('dashboard::dashboard.resource.destination.actions.delete')),
                ])->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('primary')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('dashboard::dashboard.resource.destination.actions.bulk_delete')),
                ]),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('dashboard::dashboard.resource.destination.actions.create')),
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
            'index' => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),
            'edit' => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}
