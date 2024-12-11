<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AdminResource\Pages\CreateAdmin;
use App\Filament\Admin\Resources\AdminResource\Pages\EditAdmin;
use App\Filament\Admin\Resources\AdminResource\Pages\ListAdmins;
use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = -2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('dashboard::dashboard.resource.admin.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard::dashboard.resource.admin.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.resource.admin.navigation.group');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'roles.name', 'phone_number'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('dashboard::dashboard.resource.admin.messages.search.role') => $record?->roles->pluck('name')->implode(', '),
            __('dashboard::dashboard.resource.admin.messages.search.email') => $record?->email,
            __('dashboard::dashboard.resource.admin.messages.search.phone') => $record?->phone_number,
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
                            ->label(__('dashboard::dashboard.resource.admin.form.name'))
                            ->minLength(2)
                            ->maxLength(255)
                            ->columnSpan('full')
                            ->required(),

                        Forms\Components\FileUpload::make('avatar_url')
                            ->label(__('dashboard::dashboard.resource.admin.form.avatar'))
                            ->image()
                            ->optimize('webp')
                            ->imageEditor()
                            ->imagePreviewHeight('250')
                            ->panelAspectRatio('7:2')
                            ->panelLayout('integrated')
                            ->columnSpan('full'),

                        Forms\Components\TextInput::make('email')
                            ->label(__('dashboard::dashboard.resource.admin.form.email'))
                            ->required()
                            ->prefixIcon('heroicon-m-envelope')
                            ->columnSpan('full')
                            ->email(),

                        Forms\Components\TextInput::make('phone_number')
                            ->label(__('dashboard::dashboard.resource.admin.form.phone_number'))
                            ->prefixIcon('heroicon-o-phone')
                            ->columnSpan('full'),

                        Forms\Components\Textarea::make('notes')
                            ->label(__('dashboard::dashboard.resource.admin.form.notes'))
                            ->columnSpan('full'),

                        Forms\Components\TextInput::make('password')
                            ->label(__('dashboard::dashboard.resource.admin.form.password'))
                            ->password()
                            ->confirmed()
                            ->columnSpan(1)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label(__('dashboard::dashboard.resource.admin.form.password_confirmation'))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->columnSpan(1)
                            ->password(),
                    ]),

                Forms\Components\Section::make(__('dashboard::dashboard.resource.admin.form.roles_section'))
                    ->schema([
                        Forms\Components\Select::make('roles')
                            ->label(__('dashboard::dashboard.resource.admin.form.roles'))
                            ->required()
                            ->multiple()
                            ->relationship('roles', 'name'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('dashboard::dashboard.resource.admin.table.id'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('dashboard::dashboard.resource.admin.table.name'))
                    ->description(fn (Admin $record) => $record?->notes)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\ImageColumn::make('avatar_url')
                    ->toggleable()
                    ->label(__('dashboard::dashboard.resource.admin.table.avatar'))
                    ->defaultImageUrl(url('https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&r=g&s=250'))
                    ->circular(),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('dashboard::dashboard.resource.admin.table.email'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('dashboard::dashboard.resource.admin.table.phone_number'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label(__('dashboard::dashboard.resource.admin.table.roles'))
                    ->badge()
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dashboard::dashboard.resource.admin.table.created_at'))
                    ->date()
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
                        ->label(__('dashboard::dashboard.resource.admin.actions.edit')),
                    Tables\Actions\DeleteAction::make()
                        ->label(__('dashboard::dashboard.resource.admin.actions.delete')),
                ])->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('primary')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('dashboard::dashboard.resource.admin.actions.bulk_delete')),
                ]),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('dashboard::dashboard.resource.admin.actions.create')),
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
            'index' => ListAdmins::route('/'),
            'create' => CreateAdmin::route('/create'),
            'edit' => EditAdmin::route('/{record}/edit'),
        ];
    }
}
