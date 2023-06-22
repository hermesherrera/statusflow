<?php

namespace HermesHerrera\StatusFlow\Filament\Resources\StatusFlowResource\Pages;

use HermesHerrera\StatusFlow\Filament\Resources\StatusFlowResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatusFlow extends EditRecord
{
    protected static string $resource = StatusFlowResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
