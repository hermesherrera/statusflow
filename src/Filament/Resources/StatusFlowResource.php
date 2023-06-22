<?php

namespace HermesHerrera\StatusFlow\Filament\Resources;

use App\Models\ReservationVehiclePrepare;
use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use HermesHerrera\StatusFlow\Models\StatusFlow;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use HermesHerrera\StatusFlow\Filament\Resources\StatusFlowResource\Pages;
use HermesHerrera\StatusFlow\Filament\Resources\StatusFlowResource\RelationManagers\DependecyRelationManager;
use HermesHerrera\StatusFlow\Rules\OnlyOneDefaultStatusRule;
use Illuminate\Validation\Rule;

class StatusFlowResource extends Resource
{
    protected static ?string $model = StatusFlow::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('StatusFlow::general.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('StatusFlow::general.plural');
    }

    public static function getNavigationSort() : int
    {
        return config('status_flow.navigation_group_sort', 100);;
    }

    public static function getNavigationGroup(): string
    {
        return __(config('status_flow.navigation_group', ''));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->rule(fn (?StatusFlow $record, Closure $get) => 
                                Rule::unique('status_flows', 'name')
                                    ->ignore($record?->id)
                                    ->where('model', $get('model'))
                            )
                            ->label(__('StatusFlow::general.name')),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->label(__('StatusFlow::general.title')),
                        Forms\Components\Select::make('model')
                            ->reactive()
                            ->required()
                            ->options(config('status_flow.models'))
                            ->label(__('StatusFlow::general.model'))
                            ->rule(fn (?StatusFlow $record, Closure $get) => 
                                New OnlyOneDefaultStatusRule($record?->id, $get('is_default'))
                            ),
                        Forms\Components\Select::make('color')
                            ->label(__('StatusFlow::general.color'))
                            ->options(config('status_flow.options_color')), 
                        Forms\Components\Toggle::make('is_default')
                            ->label(__('StatusFlow::general.is_default')),
                        Forms\Components\Toggle::make('is_editable')
                            ->label(__('StatusFlow::general.is_editable')),
                        Forms\Components\Toggle::make('is_notifiable')
                            ->label(__('StatusFlow::general.is_notifiable')),
                        Forms\Components\Toggle::make('is_finalized')
                            ->label(__('StatusFlow::general.is_finalized')),
                        Forms\Components\Toggle::make('active')
                            ->default(true)
                            ->label(__('StatusFlow::general.active')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label(__('StatusFlow::general.name')),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label(__('StatusFlow::general.title'))
                    ->color(fn (StatusFlow $record) => $record->color),
                Tables\Columns\TextColumn::make('model')
                    ->searchable()
                    ->enum(config('status_flow.models'))
                    ->label(__('StatusFlow::general.model')),
                Tables\Columns\IconColumn::make('is_default')
                    ->boolean()
                    ->label(__('StatusFlow::general.is_default')),
                Tables\Columns\ToggleColumn::make('active')
                    ->label(__('StatusFlow::general.active')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('model')
                    ->options(config('status_flow.models')),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->tooltip(__('StatusFlow::general.edit')),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->tooltip(__('StatusFlow::general.delete')),
                Tables\Actions\RestoreAction::make()
                    ->label('')
                    ->tooltip(__('StatusFlow::general.restore')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            DependecyRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStatusFlows::route('/'),
            'create' => Pages\CreateStatusFlow::route('/create'),
            'edit' => Pages\EditStatusFlow::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
