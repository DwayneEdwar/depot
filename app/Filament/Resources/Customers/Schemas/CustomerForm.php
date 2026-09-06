<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama pelanggan')
                    ->required()
                    ->maxLength(255),

                TextInput::make('whatsapp_number')
                    ->label('Nomor WhatsApp')
                    ->tel()
                    ->maxLength(20)
                    ->placeholder('08xxxxxxxxxx'),

                Textarea::make('address')
                    ->label('Alamat')
                    ->rows(4)
                    ->placeholder('Masukkan alamat lengkap pelanggan'),

                Textarea::make('notes')
                    ->label('Catatan')
                    ->rows(3)
                    ->placeholder('Catatan tambahan jika ada'),

                Checkbox::make('is_active')
                    ->label('Pelanggan aktif')
                    ->default(true),
            ]);
    }
}
