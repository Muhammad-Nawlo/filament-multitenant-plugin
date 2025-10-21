<?php

namespace MuhammadNawlo\MultitenantPlugin\Resources\Pages;

use Filament\Resources\Pages\CreateRecord;
use MuhammadNawlo\MultitenantPlugin\Resources\TenantResource;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;
}
