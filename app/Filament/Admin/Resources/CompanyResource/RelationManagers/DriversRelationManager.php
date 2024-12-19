<?php

namespace App\Filament\Admin\Resources\CompanyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use App\Models\Driver;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\ActionSize;
use App\Models\Bus;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class DriversRelationManager extends RelationManager
{
    protected static string $relationship = 'drivers';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('dashboard::dashboard.resource.driver.plural_label');
    }

    protected function getTableHeading(): string | Htmlable
    {
        return __('dashboard::dashboard.resource.driver.plural_label');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('dashboard::dashboard.resource.driver.form.name'))
                            ->minLength(2)
                            ->maxLength(255)
                            ->columnSpan('full')
                            ->required(),

                        Forms\Components\TextInput::make('home_address')
                            ->label(__('dashboard::dashboard.resource.driver.form.home_address'))
                            ->columnSpan('full'),

                        Forms\Components\FileUpload::make('avatar_url')
                            ->label(__('dashboard::dashboard.resource.driver.form.avatar'))
                            ->image()
                            ->optimize('webp')
                            ->imageEditor()
                            ->imagePreviewHeight('250')
                            ->panelAspectRatio('7:2')
                            ->panelLayout('integrated')
                            ->columnSpan('full'),

                        Forms\Components\TextInput::make('phone_number')
                            ->label(__('dashboard::dashboard.resource.driver.form.phone_number'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->prefixIcon('heroicon-o-phone')
                            ->columnSpan('full'),

                        Forms\Components\Textarea::make('notes')
                            ->label(__('dashboard::dashboard.resource.driver.form.notes'))
                            ->columnSpan('full'),

                        Forms\Components\TextInput::make('password')
                            ->label(__('dashboard::dashboard.resource.driver.form.password'))
                            ->password()
                            ->confirmed()
                            ->columnSpan(1)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label(__('dashboard::dashboard.resource.driver.form.password_confirmation'))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->columnSpan(1)
                            ->password(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('dashboard::dashboard.resource.driver.table.id'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('dashboard::dashboard.resource.driver.table.name'))
                    ->description(fn (Driver $record) => $record?->notes)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label(__('dashboard::dashboard.resource.driver.table.avatar'))
                    ->toggleable()
                    ->defaultImageUrl(url('https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&r=g&s=250'))
                    ->circular(),

                Tables\Columns\TextColumn::make('bus.number')
                    ->label(__('dashboard::dashboard.resource.driver.table.bus_number'))
                    ->description(fn (Driver $record) => $record?->bus ? "{$record?->bus->name} - {$record?->bus->notes}".($record?->bus->is_active ? ' (Active)' : ' (Inactive)') : null)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('dashboard::dashboard.resource.driver.table.phone_number'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('home_address')
                    ->label(__('dashboard::dashboard.resource.driver.table.home_address'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dashboard::dashboard.resource.driver.table.created_at'))
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
                    ->label(__('dashboard::dashboard.resource.driver.actions.create')),
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label(__('dashboard::dashboard.resource.driver.actions.edit')),
                    Tables\Actions\DeleteAction::make()
                        ->label(__('dashboard::dashboard.resource.driver.actions.delete')),
                    Tables\Actions\Action::make('removeBus')
                        ->label(__('dashboard::dashboard.resource.driver.actions.remove_bus'))
                        ->icon('heroicon-m-user-minus')
                        ->requiresConfirmation()
                        ->action(function (Driver $record) {
                            $bus = Bus::find($record->bus->id);
                            $bus->driver()->dissociate();
                            $bus->save();
                        })
                        ->visible(fn (Driver $record) => $record->bus()->exists())
                        ->color('danger'),
                ])->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('primary')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('dashboard::dashboard.resource.driver.actions.bulk_delete')),
                ]),
            ]);
    }
}
