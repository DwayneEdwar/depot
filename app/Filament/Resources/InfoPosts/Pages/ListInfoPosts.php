<?php

namespace App\Filament\Resources\InfoPosts\Pages;

use App\Filament\Resources\InfoPosts\InfoPostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInfoPosts extends ListRecords
{
    protected static string $resource = InfoPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
