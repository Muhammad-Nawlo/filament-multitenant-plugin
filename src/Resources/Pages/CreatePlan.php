<?php

namespace MuhammadNawlo\MultitenantPlugin\Resources\Pages;

use Filament\Resources\Pages\CreateRecord;
use MuhammadNawlo\MultitenantPlugin\Resources\PlanResource;

class CreatePlan extends CreateRecord
{
    protected static string $resource = PlanResource::class;
}
