<?php

namespace MuhammadNawlo\MultitenantPlugin\Resources\Pages;

use Filament\Resources\Pages\ListRecords;
use MuhammadNawlo\MultitenantPlugin\Resources\PlanResource;

class ListPlans extends ListRecords
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
