<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSiteSetting extends CreateRecord
{
    protected static string $resource = SiteSettingsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['key'] ?? null) === 'pricing_presets' && isset($data['pricing_presets'])) {
            $data['value'] = json_encode($data['pricing_presets'], JSON_THROW_ON_ERROR);
            unset($data['pricing_presets']);
        }

        return $data;
    }
}
