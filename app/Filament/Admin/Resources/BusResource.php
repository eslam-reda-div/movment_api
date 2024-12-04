<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BusResource\Pages;
use App\Models\Bus;
use App\Models\Company;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BusResource extends Resource
{
    protected static ?string $model = Bus::class;

    protected static ?string $navigationIcon = 'ionicon-bus-outline';

    protected static ?string $recordTitleAttribute = 'number';

    public static function getModelLabel(): string
    {
        return __('dashboard::dashboard.resource.bus.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard::dashboard.resource.bus.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.resource.bus.navigation.group');
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
            __('dashboard::dashboard.resource.bus.messages.search.number') => $record?->number,
            __('dashboard::dashboard.resource.bus.messages.search.company') => $record?->company?->name,
            __('dashboard::dashboard.resource.bus.messages.search.driver') => $record?->driver?->name,
            __('dashboard::dashboard.resource.bus.messages.search.driver_phone') => $record?->driver?->phone_number,
            __('dashboard::dashboard.resource.bus.messages.search.seats') => $record?->seats_count,
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
                            ->label(__('dashboard::dashboard.resource.bus.form.name'))
                            ->columnSpan('full'),

                        Forms\Components\FileUpload::make('image_url')
                            ->label(__('dashboard::dashboard.resource.bus.form.image'))
                            ->image()
                            ->optimize('webp')
                            ->imageEditor()
                            ->imagePreviewHeight('250')
                            ->panelAspectRatio('7:2')
                            ->panelLayout('integrated')
                            ->columnSpan('full'),

                        Forms\Components\TextInput::make('number')
                            ->label(__('dashboard::dashboard.resource.bus.form.number'))
                            ->required()
                            ->prefixIcon('fluentui-number-symbol-28')
                            ->columnSpan('full'),

                        \Icetalker\FilamentStepper\Forms\Components\Stepper::make('seats_count')
                            ->label(__('dashboard::dashboard.resource.bus.form.seats_count'))
                            ->columnSpan('full')
                            ->minValue(1)
                            ->default(10),

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

                        Forms\Components\Select::make('driver_id')
                            ->label(__('dashboard::dashboard.resource.bus.form.driver'))
                            ->relationship('driver', 'name')
                            ->columnSpan('full')
                            ->options(function (Forms\Get $get) {
                                $companyId = $get('company_id');
                                $query = Driver::whereDoesntHave('bus');

                                if ($companyId) {
                                    return $query->where('company_id', $companyId)
                                        ->pluck('name', 'id');
                                }

                                return $query->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->native(false),

                        Forms\Components\Textarea::make('notes')
                            ->label(__('dashboard::dashboard.resource.bus.form.notes'))
                            ->columnSpan('full'),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('dashboard::dashboard.resource.bus.form.is_active'))
                            ->default(true)
                            ->inline(false)
                            ->onColor('success')
                            ->offColor('danger')
                            ->columnSpan('full')
                            ->disabled(function (Forms\Get $get, Forms\Set $set, ?Bus $record) {
                                $companyId = $get('company_id');
                                if (! $companyId) {
                                    return false;
                                }

                                $company = Company::find($companyId);

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
                            ->helperText(function (Forms\Get $get, ?Bus $record) {
                                $companyId = $get('company_id');
                                if (! $companyId) {
                                    return null;
                                }

                                $company = Company::find($companyId);

                                if ($record && $record->is_active) {
                                    return null;
                                }

                                $activeCount = $company->buses()->where('is_active', true)->count();
                                $isLimitReached = $activeCount >= $company->bus_limit;

                                return $isLimitReached
                                    ? __('dashboard::dashboard.resource.bus.form.limit_reached', ['0' => $company->bus_limit])
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
                Tables\Columns\TextColumn::make('id')
                    ->label(__('dashboard::dashboard.resource.bus.table.id'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('number')
                    ->label(__('dashboard::dashboard.resource.bus.table.number'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('dashboard::dashboard.resource.bus.table.name'))
                    ->default(fn (Bus $record) => $record?->notes)
                    ->description(fn (Bus $record) => $record?->name ? $record?->notes : null)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('image_url')
                    ->label(__('dashboard::dashboard.resource.bus.table.image'))
                    ->toggleable()
                    ->defaultImageUrl(url('https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&r=g&s=250')),

                Tables\Columns\TextColumn::make('is_active')
                    ->badge()
                    ->label(__('dashboard::dashboard.resource.bus.table.status_lab'))
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->toggleable()
                    ->formatStateUsing(fn (bool $state): string => $state
                        ? __('dashboard::dashboard.resource.bus.table.status.active')
                        : __('dashboard::dashboard.resource.bus.table.status.inactive'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('seats_count')
                    ->label(__('dashboard::dashboard.resource.bus.table.seats_count'))
                    ->toggleable()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('company.name')
                    ->label(__('dashboard::dashboard.resource.bus.table.company'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('driver.name')
                    ->label(__('dashboard::dashboard.resource.bus.table.driver'))
                    ->description(fn (Bus $record) => $record?->driver?->phone_number)
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dashboard::dashboard.resource.bus.table.created_at'))
                    ->date()
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('company_id')
                    ->label(__('dashboard::dashboard.resource.bus.filters.company'))
                    ->native(false)
                    ->options(fn (): array => Company::get()->pluck('name', 'id')->toArray()),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label(__('dashboard::dashboard.resource.bus.actions.edit')),

                    Tables\Actions\DeleteAction::make()
                        ->label(__('dashboard::dashboard.resource.bus.actions.delete')),

                    Tables\Actions\Action::make('activate')
                        ->label(function (Bus $record) {
                            if (! $record->company_id) {
                                return __('dashboard::dashboard.resource.bus.actions.activate');
                            }

                            $company = $record->company;
                            $reachedLimit = $company->buses()->where('is_active', true)->count() >= $company->bus_limit;

                            return $reachedLimit
                                ? __('dashboard::dashboard.resource.bus.actions.activate_limit')
                                : __('dashboard::dashboard.resource.bus.actions.activate');
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
                            if (! $record->company_id) {
                                return false;
                            }
                            $company = $record->company;

                            return $company->buses()->where('is_active', true)->count() >= $company->bus_limit;
                        }),

                    Tables\Actions\Action::make('deactivate')
                        ->label(__('dashboard::dashboard.resource.bus.actions.deactivate'))
                        ->icon('heroicon-m-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Bus $record) {
                            $record->update(['is_active' => false]);
                        })
                        ->visible(fn (Bus $record) => $record->is_active),

                    Tables\Actions\Action::make('removeDriver')
                        ->label(__('dashboard::dashboard.resource.bus.actions.remove_driver'))
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
                        ->label(__('dashboard::dashboard.resource.bus.actions.bulk_delete')),
                ]),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('dashboard::dashboard.resource.bus.actions.create')),
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
