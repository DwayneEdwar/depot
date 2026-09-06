<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['key'] ?? null) === 'pricing_presets' && isset($data['pricing_presets'])) {
            $data['value'] = json_encode($data['pricing_presets'], JSON_THROW_ON_ERROR);
            unset($data['pricing_presets']);
        }

        return $data;
    }
}
