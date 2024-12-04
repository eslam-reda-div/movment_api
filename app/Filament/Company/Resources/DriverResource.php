<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\DriverResource\Pages;
use App\Models\Bus;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'healthicons-o-construction-worker';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('dashboard::dashboard.resource.com_driver.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard::dashboard.resource.com_driver.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.resource.com_driver.navigation.group');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'phone_number',
            'home_address',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('dashboard::dashboard.resource.com_driver.messages.search.name') => $record?->name,
            __('dashboard::dashboard.resource.com_driver.messages.search.phone_number') => $record?->phone_number,
            __('dashboard::dashboard.resource.com_driver.messages.search.home_address') => $record?->home_address,
            __('dashboard::dashboard.resource.com_driver.messages.search.bus') => $record?->bus?->number,
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
                            ->label(__('dashboard::dashboard.resource.com_driver.form.name'))
                            ->minLength(2)
                            ->maxLength(255)
                            ->columnSpan('full')
                            ->required(),
                        Forms\Components\TextInput::make('home_address')
                            ->label(__('dashboard::dashboard.resource.com_driver.form.home_address'))
                            ->columnSpan('full'),
                        Forms\Components\FileUpload::make('avatar_url')
                            ->label(__('dashboard::dashboard.resource.com_driver.form.avatar'))
                            ->image()
                            ->optimize('webp')
                            ->imageEditor()
                            ->imagePreviewHeight('250')
                            ->panelAspectRatio('7:2')
                            ->panelLayout('integrated')
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('phone_number')
                            ->label(__('dashboard::dashboard.resource.com_driver.form.phone_number'))
                            ->required()
                            ->prefixIcon('heroicon-o-phone')
                            ->columnSpan('full'),
                        Forms\Components\Select::make('bus_id')
                            ->label(__('dashboard::dashboard.resource.com_driver.form.bus'))
                            ->columnSpan('full')
                            ->options(function () {
                                return Bus::whereNull('driver_id')
                                    ->where('company_id', auth('company')->id())
                                    ->pluck('number', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Forms\Components\Textarea::make('notes')
                            ->label(__('dashboard::dashboard.resource.com_driver.form.notes'))
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('password')
                            ->label(__('dashboard::dashboard.resource.com_driver.form.password'))
                            ->password()
                            ->confirmed()
                            ->columnSpan(1)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label(__('dashboard::dashboard.resource.com_driver.form.password_confirmation'))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->columnSpan(1)
                            ->password(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('dashboard::dashboard.resource.com_driver.table.id'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('dashboard::dashboard.resource.com_driver.table.name'))
                    ->description(fn (Driver $record) => $record?->notes)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label(__('dashboard::dashboard.resource.com_driver.table.avatar'))
                    ->toggleable()
                    ->defaultImageUrl(url('https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&r=g&s=250'))
                    ->circular(),
                Tables\Columns\TextColumn::make('bus.number')
                    ->label(__('dashboard::dashboard.resource.com_driver.table.bus_number'))
                    ->description(fn (Driver $record) => $record?->bus ? "{$record?->bus->name} - {$record?->bus->notes}".($record?->bus->is_active ? ' (Active)' : ' (Inactive)') : null)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('dashboard::dashboard.resource.com_driver.table.phone_number'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('home_address')
                    ->label(__('dashboard::dashboard.resource.com_driver.table.home_address'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dashboard::dashboard.resource.com_driver.table.created_at'))
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
                        ->label(__('dashboard::dashboard.resource.com_driver.actions.edit')),
                    Tables\Actions\DeleteAction::make()
                        ->label(__('dashboard::dashboard.resource.com_driver.actions.delete')),
                    Tables\Actions\Action::make('removeBus')
                        ->label(__('dashboard::dashboard.resource.com_driver.actions.remove_bus'))
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
                        ->label(__('dashboard::dashboard.resource.com_driver.actions.bulk_delete')),
                ]),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('dashboard::dashboard.resource.com_driver.actions.create')),
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
