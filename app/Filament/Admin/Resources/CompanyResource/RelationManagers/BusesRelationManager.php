<?php

namespace App\Filament\Admin\Resources\CompanyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\ActionSize;
use App\Models\Bus;
use App\Models\Driver;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BusesRelationManager extends RelationManager
{
    protected static string $relationship = 'buses';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('dashboard::dashboard.resource.bus.plural_label');
    }

    protected function getTableHeading(): string | Htmlable
    {
        return __('dashboard::dashboard.resource.bus.plural_label');
    }

    public function form(Form $form): Form
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

                        Forms\Components\Select::make('driver_id')
                            ->label(__('dashboard::dashboard.resource.bus.form.driver'))
                            ->relationship('driver', 'name')
                            ->columnSpan('full')
                            ->options(function () {
                                $companyId = $this->getOwnerRecord()->id;

                                return Driver::whereDoesntHave('bus')
                                    ->where('company_id', $companyId)
                                    ->pluck('name', 'id');
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
                                $company = $this->getOwnerRecord();

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
                            ->helperText(function (?Bus $record) {
                                $company = $this->getOwnerRecord();

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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('number')
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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('dashboard::dashboard.resource.bus.actions.create')),
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
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
            ]);
    }
}
