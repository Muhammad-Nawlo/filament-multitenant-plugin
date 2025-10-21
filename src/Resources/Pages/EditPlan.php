<?php

namespace MuhammadNawlo\MultitenantPlugin\Resources\Pages;

use Filament\Resources\Pages\EditRecord;
use MuhammadNawlo\MultitenantPlugin\Resources\PlanResource;

class EditPlan extends EditRecord
{
    protected static string $resource = PlanResource::class;
}
