<?php

namespace MuhammadNawlo\MultitenantPlugin\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use MuhammadNawlo\MultitenantPlugin\Models\Tenant;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Tenants';

    protected static ?string $modelLabel = 'Tenant';

    protected static ?string $pluralModelLabel = 'Tenants';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('Tenant ID')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Unique identifier for the tenant'),

                TextInput::make('name')
                    ->label('Tenant Name')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Display name for the tenant'),

                TextInput::make('domain')
                    ->label('Domain')
                    ->required()
                    ->url()
                    ->unique(ignoreRecord: true)
                    ->helperText('Primary domain for the tenant (e.g., tenant.example.com)'),

                TextInput::make('database')
                    ->label('Database Name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Database name for the tenant'),

                Select::make('plan_id')
                    ->label('Subscription Plan')
                    ->relationship('plan', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->helperText('Select the subscription plan for this tenant'),

                Textarea::make('data')
                    ->label('Additional Data')
                    ->rows(3)
                    ->helperText('JSON data for additional tenant information'),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Whether the tenant is active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('domain')
                    ->label('Domain')
                    ->searchable()
                    ->sortable()
                    ->url(fn (Tenant $record): string => 'https://' . $record->domain)
                    ->openUrlInNewTab(),

                TextColumn::make('database')
                    ->label('Database')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('plan.name')
                    ->label('Plan')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                TextColumn::make('plan.price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable(),

                BadgeColumn::make('is_active')
                    ->label('Status')
                    ->getStateUsing(fn (Tenant $record): string => $record->is_active ? 'Active' : 'Inactive')
                    ->colors([
                        'success' => 'Active',
                        'danger' => 'Inactive',
                    ]),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('plan_id')
                    ->label('Plan')
                    ->relationship('plan', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All tenants')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('visit_tenant')
                    ->label('Visit Tenant')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Tenant $record): string => 'https://' . $record->domain)
                    ->openUrlInNewTab(),
                Action::make('manage_database')
                    ->label('Database')
                    ->icon('heroicon-o-server')
                    ->action(function (Tenant $record) {
                        // Custom logic to manage tenant database
                        // This could open a modal or redirect to database management
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'view' => Pages\ViewTenant::route('/{record}'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['plan']);
    }
}
