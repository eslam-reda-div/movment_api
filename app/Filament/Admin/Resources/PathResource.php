<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PathResource\Pages;
use App\Models\Company;
use App\Models\Destination;
use App\Models\Path;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PathResource extends Resource
{
    protected static ?string $model = Path::class;

    protected static ?string $navigationIcon = 'bx-trip';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('dashboard::dashboard.resource.com_path.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.resource.bus.navigation.group');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard::dashboard.resource.com_path.plural_label');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'domain.name',
            'fromDestination.name',
            'toDestination.name',
            'stops',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('dashboard::dashboard.resource.com_path.messages.search.name') => $record->name,
            __('dashboard::dashboard.resource.com_path.messages.search.domain') => $record?->domain->name,
            __('dashboard::dashboard.resource.com_path.messages.search.from') => $record?->fromDestination->name,
            __('dashboard::dashboard.resource.com_path.messages.search.to') => $record?->toDestination->name,
            __('dashboard::dashboard.resource.com_path.messages.search.stops') => collect($record->stops)
                ->pluck('destination_id')
                ->map(function ($destinationId) {
                    return Destination::find($destinationId)?->name ?? '';
                })
                ->filter()
                ->join(', '),
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
                            ->label(__('dashboard::dashboard.resource.com_path.form.name'))
                            ->columnSpan('full')
                            ->required(),

                        Forms\Components\Select::make('company_id')
                            ->label(__('dashboard::dashboard.resource.bus.form.company'))
                            ->relationship('company', 'name')
                            ->columnSpan('full')
                            ->options(function () {
                                return Company::all()->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->live(),

                        Forms\Components\Select::make('domain_id')
                            ->label(__('dashboard::dashboard.resource.com_path.form.domain'))
                            ->relationship('domain', 'name', fn ($query) => $query->where('is_active', true))
                            ->required()
                            ->columnSpan('full')
                            ->live()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->afterStateUpdated(fn (callable $set) => [
                                $set('from', null),
                                $set('to', null),
                                $set('stops', null),
                                $set('fromDestination', null),
                                $set('toDestination', null),
                                $set('stops', []),
                            ]),
                        Forms\Components\Section::make()
                            ->heading(__('dashboard::dashboard.resource.com_path.form.path.label'))
                            ->schema([
                                Forms\Components\Select::make('from')
                                    ->label(__('dashboard::dashboard.resource.com_path.form.path.from'))
                                    ->relationship(
                                        'fromDestination',
                                        'name',
                                        fn ($query, $get) => $query
                                            ->where('domain_id', $get('domain_id'))
                                            ->where('is_active', true)
                                    )
                                    ->columnSpan('full')
                                    ->live()
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->required()
                                    ->visible(fn ($get) => filled($get('domain_id'))),
                                Forms\Components\Section::make()
                                    ->heading(__('dashboard::dashboard.resource.com_path.form.path.stops.label'))
                                    ->schema([
                                        Forms\Components\Repeater::make('stops')
                                            ->hiddenLabel()
                                            ->addActionLabel(__('dashboard::dashboard.resource.com_path.form.path.stops.add'))
                                            ->schema([
                                                Forms\Components\Select::make('destination_id')
                                                    ->label(__('dashboard::dashboard.resource.com_path.form.path.stops.destination'))
                                                    ->options(function ($get) {
                                                        $domainId = $get('../../domain_id');
                                                        if (! $domainId) {
                                                            return [];
                                                        }

                                                        return Destination::where('is_active', true)
                                                            ->pluck('name', 'id');
                                                    })
                                                    ->required()
                                                    ->searchable()
                                                    ->preload()
                                                    ->columnSpan('full')
                                                    ->native(false),
                                            ])
                                            ->visible(fn ($get) => filled($get('domain_id')))
                                            ->columnSpan('full')
                                            ->defaultItems(0)
                                            ->deletable(true)
                                            ->reorderable(true)
                                            ->reorderableWithButtons(true)
                                            ->reorderableWithDragAndDrop(true),
                                    ]),
                                Forms\Components\Select::make('to')
                                    ->label(__('dashboard::dashboard.resource.com_path.form.path.to'))
                                    ->relationship(
                                        'toDestination',
                                        'name',
                                        fn ($query, $get) => $query
                                            ->where('domain_id', $get('domain_id'))
                                            ->where('is_active', true)
                                    )
                                    ->columnSpan('full')
                                    ->searchable()
                                    ->native(false)
                                    ->required()
                                    ->visible(fn ($get) => filled($get('domain_id')))
                                    ->preload(),
                            ])
                            ->columns(2)
                            ->columnSpan('full')
                            ->visible(fn ($get) => filled($get('domain_id'))),
                        Forms\Components\Textarea::make('notes')
                            ->label(__('dashboard::dashboard.resource.com_path.form.notes'))
                            ->columnSpan('full'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('dashboard::dashboard.resource.com_path.table.id'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('dashboard::dashboard.resource.com_path.table.name'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label(__('dashboard::dashboard.resource.driver.table.company'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('domain.name')
                    ->label(__('dashboard::dashboard.resource.com_path.table.domain'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('fromDestination.name')
                    ->label(__('dashboard::dashboard.resource.com_path.table.from'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('stops')
                    ->label(__('dashboard::dashboard.resource.com_path.table.stops'))
                    ->badge()
                    ->toggleable()
                    ->sortable()
                    ->searchable()
                    ->state(function (Path $record) {
                        $stops = $record?->stops;

                        if (! $stops) {
                            return '';
                        }

                        return collect($stops)
                            ->map(function ($stop) {
                                return $stop['name'] ?? 'f';
                            })
                            ->filter();
                    }),
                Tables\Columns\TextColumn::make('toDestination.name')
                    ->label(__('dashboard::dashboard.resource.com_path.table.to'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dashboard::dashboard.resource.com_path.table.created_at'))
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
                        ->label(__('dashboard::dashboard.resource.com_path.actions.edit')),
                    Tables\Actions\DeleteAction::make()
                        ->label(__('dashboard::dashboard.resource.com_path.actions.delete')),
                ])->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('primary')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('dashboard::dashboard.resource.com_path.actions.bulk_delete')),
                ]),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('dashboard::dashboard.resource.com_path.actions.create')),
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
            'index' => Pages\ListPaths::route('/'),
            'create' => Pages\CreatePath::route('/create'),
            'edit' => Pages\EditPath::route('/{record}/edit'),
        ];
    }
}
