<?php

namespace MuhammadNawlo\MultitenantPlugin\Resources\Pages;

use Filament\Resources\Pages\ViewRecord;
use MuhammadNawlo\MultitenantPlugin\Resources\TenantResource;

class ViewTenant extends ViewRecord
{
    protected static string $resource = TenantResource::class;
}
