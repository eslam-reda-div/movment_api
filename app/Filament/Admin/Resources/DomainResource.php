<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DomainResource\Pages;
use App\Models\Domain;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DomainResource extends Resource
{
    protected static ?string $model = Domain::class;

    protected static ?string $navigationIcon = 'entypo-location';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('dashboard::dashboard.resource.domain.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('dashboard::dashboard.resource.domain.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.resource.domain.navigation.group');
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
            __('dashboard::dashboard.resource.domain.messages.search.name') => $record?->name,
            __('dashboard::dashboard.resource.domain.messages.search.destinations') => $record?->destinations->count(),
            __('dashboard::dashboard.resource.domain.messages.search.paths') => $record?->paths->count(),
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
                            ->label(__('dashboard::dashboard.resource.domain.form.name'))
                            ->columnSpan('full')
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label(__('dashboard::dashboard.resource.domain.form.notes'))
                            ->columnSpan('full'),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('dashboard::dashboard.resource.domain.form.is_active'))
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
                    ->label(__('dashboard::dashboard.resource.domain.table.id'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('dashboard::dashboard.resource.domain.table.name'))
                    ->description(fn (Domain $record) => $record?->notes)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('destinations')
                    ->label(__('dashboard::dashboard.resource.domain.table.destinations_count'))
                    ->toggleable()
                    ->state(fn (Domain $record) => $record?->destinations?->count()),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('dashboard::dashboard.resource.domain.table.is_active'))
                    ->onColor('success')
                    ->offColor('danger')
                    ->toggleable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dashboard::dashboard.resource.domain.table.created_at'))
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
                        ->label(__('dashboard::dashboard.resource.domain.actions.edit')),
                    Tables\Actions\DeleteAction::make()
                        ->label(__('dashboard::dashboard.resource.domain.actions.delete')),
                ])->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('primary')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('dashboard::dashboard.resource.domain.actions.bulk_delete')),
                ]),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('dashboard::dashboard.resource.domain.actions.create')),
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
            'index' => Pages\ListDomains::route('/'),
            'create' => Pages\CreateDomain::route('/create'),
            'edit' => Pages\EditDomain::route('/{record}/edit'),
        ];
    }
}
