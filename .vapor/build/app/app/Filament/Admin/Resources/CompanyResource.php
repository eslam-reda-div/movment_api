<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('dashboard::dashboard.resource.company.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard::dashboard.resource.company.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.resource.company.navigation.group');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'email',
            'phone_number',
            'address',
        ];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('dashboard::dashboard.resource.company.messages.search.name') => $record?->name,
            __('dashboard::dashboard.resource.company.messages.search.email') => $record?->email,
            __('dashboard::dashboard.resource.company.messages.search.phone_number') => $record?->phone_number,
            __('dashboard::dashboard.resource.company.messages.search.address') => $record?->address,
            __('dashboard::dashboard.resource.company.messages.search.bus_limit') => $record?->bus_limit,
            __('dashboard::dashboard.resource.company.messages.search.bus_count') => $record?->buses->count(),
            __('dashboard::dashboard.resource.company.messages.search.driver_count') => $record?->drivers->count(),
            __('dashboard::dashboard.resource.company.messages.search.trip_count') => $record?->trips->count(),
            __('dashboard::dashboard.resource.company.messages.search.path_count') => $record?->paths->count(),
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
                            ->label(__('dashboard::dashboard.resource.company.form.name'))
                            ->minLength(2)
                            ->maxLength(255)
                            ->columnSpan('full')
                            ->required(),

                        Forms\Components\FileUpload::make('avatar_url')
                            ->label(__('dashboard::dashboard.resource.company.form.avatar'))
                            ->image()
                            ->optimize('webp')
                            ->imageEditor()
                            ->imagePreviewHeight('250')
                            ->panelAspectRatio('7:2')
                            ->panelLayout('integrated')
                            ->columnSpan('full'),

                        Forms\Components\TextInput::make('email')
                            ->label(__('dashboard::dashboard.resource.company.form.email'))
                            ->required()
                            ->prefixIcon('heroicon-m-envelope')
                            ->columnSpan('full')
                            ->email(),

                        Forms\Components\TextInput::make('phone_number')
                            ->label(__('dashboard::dashboard.resource.company.form.phone_number'))
                            ->prefixIcon('heroicon-o-phone')
                            ->columnSpan('full'),

                        Forms\Components\TextInput::make('address')
                            ->label(__('dashboard::dashboard.resource.company.form.address'))
                            ->prefixIcon('heroicon-o-map-pin')
                            ->columnSpan('full'),

                        \Icetalker\FilamentStepper\Forms\Components\Stepper::make('bus_limit')
                            ->label(__('dashboard::dashboard.resource.company.form.bus_limit'))
                            ->columnSpan('full')
                            ->minValue(0)
                            ->default(1),

                        Forms\Components\Textarea::make('notes')
                            ->label(__('dashboard::dashboard.resource.company.form.notes'))
                            ->columnSpan('full'),

                        Forms\Components\TextInput::make('password')
                            ->label(__('dashboard::dashboard.resource.company.form.password'))
                            ->password()
                            ->confirmed()
                            ->columnSpan(1)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label(__('dashboard::dashboard.resource.company.form.password_confirmation'))
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
                    ->label(__('dashboard::dashboard.resource.company.table.id'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('dashboard::dashboard.resource.company.table.name'))
                    ->description(fn (Company $record) => $record?->notes)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label(__('dashboard::dashboard.resource.company.table.avatar'))
                    ->toggleable()
                    ->defaultImageUrl(url('https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&r=g&s=250'))
                    ->circular(),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('dashboard::dashboard.resource.company.table.email'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('bus_limit')
                    ->label(__('dashboard::dashboard.resource.company.table.bus_limit'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('drivers')
                    ->label(__('dashboard::dashboard.resource.company.table.drivers_count'))
                    ->toggleable()
                    ->state(fn (Company $record) => $record?->drivers?->count()),

                Tables\Columns\TextColumn::make('buses')
                    ->label(__('dashboard::dashboard.resource.company.table.buses_count'))
                    ->toggleable()
                    ->state(fn (Company $record) => $record?->buses?->count()),

                Tables\Columns\TextColumn::make('trips')
                    ->label(__('dashboard::dashboard.resource.company.table.trips_count'))
                    ->toggleable()
                    ->state(fn (Company $record) => $record?->trips?->count()),

                Tables\Columns\TextColumn::make('paths')
                    ->label(__('dashboard::dashboard.resource.company.table.paths_count'))
                    ->toggleable()
                    ->state(fn (Company $record) => $record?->paths?->count()),

                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('dashboard::dashboard.resource.company.table.phone_number'))
                    ->toggleable()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('address')
                    ->label(__('dashboard::dashboard.resource.company.table.address'))
                    ->toggleable()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dashboard::dashboard.resource.company.table.created_at'))
                    ->toggleable()
                    ->date()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label(__('dashboard::dashboard.resource.company.actions.edit')),
                    Tables\Actions\DeleteAction::make()
                        ->label(__('dashboard::dashboard.resource.company.actions.delete')),
                ])->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('primary')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('dashboard::dashboard.resource.company.actions.bulk_delete')),
                ]),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('dashboard::dashboard.resource.company.actions.create')),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
