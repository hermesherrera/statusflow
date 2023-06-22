<?php

namespace HermesHerrera\StatusFlow\Filament\Resources\StatusFlowResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Validation\Rule;
use HermesHerrera\StatusFlow\Models\StatusFlow;
use Filament\Resources\RelationManagers\RelationManager;

class DependecyRelationManager extends RelationManager
{
    protected static string $relationship = 'dependecy';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('StatusFlow::general.dependecy_singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('StatusFlow::general.dependecy_plural');
    }  

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('status_flow_dependecy_id')
                    ->rule(fn(RelationManager $livewire) => 
                        Rule::unique('status_flow_dependecies', 'status_flow_dependecy_id')
                            ->where('status_flow_id', $livewire->ownerRecord->id)
                    )
                    ->label(__('StatusFlow::general.status_flow_dependecy_id'))
                    ->options(fn (RelationManager $livewire) => StatusFlow::selectActive($livewire->ownerRecord->model)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status.title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
