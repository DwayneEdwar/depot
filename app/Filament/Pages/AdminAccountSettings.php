<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\EditProfile;
use Filament\Schemas\Components\Component;
use Filament\Support\Icons\Heroicon;

class AdminAccountSettings extends EditProfile
{
    protected static ?string $title = 'Akun Admin';

    protected static ?string $navigationLabel = 'Akun Admin';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?int $navigationSort = 99;

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaturan';
    }

    public static function getLabel(): string
    {
        return 'Akun Admin';
    }

    protected function getNameFormComponent(): Component
    {
        return parent::getNameFormComponent()
            ->label('Nama admin');
    }

    protected function getPasswordFormComponent(): Component
    {
        return parent::getPasswordFormComponent()
            ->helperText('Biarkan kosong jika tidak ingin mengganti password.');
    }
}
