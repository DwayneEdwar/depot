<?php

namespace App\Filament\Resources\InfoPosts\Pages;

use App\Filament\Resources\InfoPosts\InfoPostResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInfoPost extends EditRecord
{
    protected static string $resource = InfoPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
