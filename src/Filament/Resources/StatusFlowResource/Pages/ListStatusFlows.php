<?php

namespace HermesHerrera\StatusFlow\Filament\Resources\StatusFlowResource\Pages;

use Filament\Pages\Actions;
use Filament\Tables\Actions\Position;
use Filament\Resources\Pages\ListRecords;
use HermesHerrera\StatusFlow\Filament\Resources\StatusFlowResource;

class ListStatusFlows extends ListRecords
{
    protected static string $resource = StatusFlowResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableActionsPosition(): ?string
    {
        return Position::BeforeCells;
    }

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }
}
