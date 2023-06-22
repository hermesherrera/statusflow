<?php

namespace HermesHerrera\StatusFlow\Filament\Resources\StatusFlowResource\Pages;

use HermesHerrera\StatusFlow\Filament\Resources\StatusFlowResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStatusFlow extends CreateRecord
{
    protected static string $resource = StatusFlowResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
