<?php

namespace MuhammadNawlo\MultitenantPlugin\Resources\Pages;

use Filament\Resources\Pages\EditRecord;
use MuhammadNawlo\MultitenantPlugin\Resources\TenantResource;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;
}
