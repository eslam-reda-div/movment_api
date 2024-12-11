<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\BusResource\Pages;
use App\Models\Bus;
use App\Models\Company;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BusResource extends Resource
{
    protected static ?string $model = Bus::class;

    protected static ?string $navigationIcon = 'ionicon-bus-outline';

    protected static ?string $recordTitleAttribute = 'number';

    public static function getModelLabel(): string
    {
        return __('dashboard::dashboard.resource.com_bus.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard::dashboard.resource.com_bus.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.resource.com_bus.navigation.group');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'number',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('dashboard::dashboard.resource.com_bus.messages.search.number') => $record?->number,
            __('dashboard::dashboard.resource.com_bus.messages.search.driver') => $record?->driver?->name,
            __('dashboard::dashboard.resource.com_bus.messages.search.driver_phone') => $record?->driver?->phone_number,
            __('dashboard::dashboard.resource.com_bus.messages.search.seats_count') => $record?->seats_count,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('company_id', auth('company')->id());
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
                        Forms\Components\TextInput::make('name')
                            ->label(__('dashboard::dashboard.resource.com_bus.form.title'))
                            ->columnSpan('full'),
                        Forms\Components\FileUpload::make('image_url')
                            ->label(__('dashboard::dashboard.resource.com_bus.form.bus_image'))
                            ->image()
                            ->optimize('webp')
                            ->imageEditor()
                            ->imagePreviewHeight('250')
                            ->panelAspectRatio('7:2')
                            ->panelLayout('integrated')
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('number')
                            ->label(__('dashboard::dashboard.resource.com_bus.form.number'))
                            ->required()
                            ->prefixIcon('fluentui-number-symbol-28')
                            ->columnSpan('full'),
                        \Icetalker\FilamentStepper\Forms\Components\Stepper::make('seats_count')
                            ->label(__('dashboard::dashboard.resource.com_bus.form.seats_count'))
                            ->columnSpan('full')
                            ->minValue(1)
                            ->default(10),
                        Forms\Components\Select::make('driver_id')
                            ->label(__('dashboard::dashboard.resource.com_bus.form.driver'))
                            ->relationship('driver', 'name')
                            ->columnSpan('full')
                            ->options(function () {
                                return Driver::where('company_id', auth('company')->id())
                                    ->whereDoesntHave('bus')
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->native(false),
                        Forms\Components\Textarea::make('notes')
                            ->label(__('dashboard::dashboard.resource.com_bus.form.notes'))
                            ->columnSpan('full'),
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('dashboard::dashboard.resource.com_bus.form.is_active'))
                            ->default(true)
                            ->inline(false)
                            ->onColor('success')
                            ->offColor('danger')
                            ->columnSpan('full')
                            ->disabled(function (Forms\Get $get, Forms\Set $set, ?Bus $record = null) {
                                $company = Company::find(auth('company')->id());

                                if ($record && $record->is_active) {
                                    return false;
                                }

                                $isDisabled = $company->buses()->where('is_active', true)->count() >= $company->bus_limit;

                                if ($isDisabled) {
                                    $set('is_active', false);
                                } else {
                                    $set('is_active', true);
                                }

                                return $isDisabled;
                            })
                            ->helperText(function (?Bus $record = null) {
                                $company = Company::find(auth('company')->id());

                                if ($record && $record->is_active) {
                                    return null;
                                }

                                $activeCount = $company->buses()
                                    ->where('is_active', true)
                                    ->when($record, fn ($query) => $query->where('id', '!=', $record->id))
                                    ->count();

                                $isLimitReached = $activeCount >= $company->bus_limit;

                                return $isLimitReached
                                    ? __('dashboard::dashboard.resource.com_bus.form.limit_reached', ['limit' => $company->bus_limit])
                                    : null;
                            })
                            ->dehydrated()
                            ->live(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label(__('dashboard::dashboard.resource.com_bus.table.number'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('dashboard::dashboard.resource.com_bus.table.title'))
                    ->default(fn (Bus $record) => $record?->notes)
                    ->description(fn (Bus $record) => $record?->name ? $record?->notes : null)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_url')
                    ->label(__('dashboard::dashboard.resource.com_bus.table.bus_image'))
                    ->toggleable()
                    ->defaultImageUrl(url('https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&r=g&s=250')),
                Tables\Columns\TextColumn::make('is_active')
                    ->label(__('dashboard::dashboard.resource.com_bus.table.is_active'))
                    ->badge()
                    ->toggleable()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state
                        ? __('dashboard::dashboard.resource.com_bus.table.states.active')
                        : __('dashboard::dashboard.resource.com_bus.table.states.inactive'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('seats_count')
                    ->label(__('dashboard::dashboard.resource.com_bus.table.seats_count'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('driver.name')
                    ->label(__('dashboard::dashboard.resource.com_bus.table.driver'))
                    ->description(fn (Bus $record) => $record?->driver?->phone_number)
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dashboard::dashboard.resource.com_bus.table.created_at'))
                    ->date()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label(__('dashboard::dashboard.resource.com_bus.actions.edit')),
                    Tables\Actions\Action::make('activate')
                        ->label(function (Bus $record) {
                            $company = $record->company;
                            $reachedLimit = $company->buses()->where('is_active', true)->count() >= $company->bus_limit;

                            return $reachedLimit
                                ? __('dashboard::dashboard.resource.com_bus.actions.activate_limit')
                                : __('dashboard::dashboard.resource.com_bus.actions.activate');
                        })
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Bus $record) {
                            $activeBusesCount = $record->company->buses()->where('is_active', true)->count();
                            if ($activeBusesCount < $record->company->bus_limit) {
                                $record->update(['is_active' => true]);
                            }
                        })
                        ->visible(fn (Bus $record) => ! $record->is_active)
                        ->disabled(function (Bus $record) {
                            return $record->company->buses()->where('is_active', true)->count() >= $record->company->bus_limit;
                        }),
                    Tables\Actions\Action::make('deactivate')
                        ->label(__('dashboard::dashboard.resource.com_bus.actions.deactivate'))
                        ->icon('heroicon-m-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Bus $record) {
                            $record->update(['is_active' => false]);
                        })
                        ->visible(fn (Bus $record) => $record->is_active),
                    Tables\Actions\Action::make('removeDriver')
                        ->label(__('dashboard::dashboard.resource.com_bus.actions.remove_driver'))
                        ->icon('heroicon-m-user-minus')
                        ->requiresConfirmation()
                        ->action(function (Bus $record) {
                            $record->driver()->dissociate();
                            $record->save();
                        })
                        ->visible(fn (Bus $record) => $record->driver_id !== null)
                        ->color('danger'),
                ])->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('primary')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('dashboard::dashboard.resource.com_bus.actions.bulk_delete')),
                ]),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('dashboard::dashboard.resource.com_bus.actions.create')),
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
            'index' => Pages\ListBuses::route('/'),
            'create' => Pages\CreateBus::route('/create'),
            'edit' => Pages\EditBus::route('/{record}/edit'),
        ];
    }
}
