<?php

namespace App\Filament\Resources\InfoPosts\Pages;

use App\Filament\Resources\InfoPosts\InfoPostResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInfoPost extends CreateRecord
{
    protected static string $resource = InfoPostResource::class;
}
