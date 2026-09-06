<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label('Kunci pengaturan')
                    ->placeholder('misalnya: site_name')
                    ->required()
                    ->live(onBlur: true)
                    ->unique(ignoreRecord: true),

                Repeater::make('pricing_presets')
                    ->label('Preset paket harga')
                    ->dehydrated(fn (Get $get): bool => $get('key') === 'pricing_presets')
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required(),
                        TextInput::make('label')
                            ->label('Nama paket')
                            ->required(),
                        TextInput::make('price')
                            ->label('Harga per galon')
                            ->numeric()
                            ->inputMode('numeric')
                            ->required(),
                    ])
                    ->addActionLabel('Tambah paket')
                    ->default([
                        ['slug' => 'standard', 'label' => 'Standar', 'price' => 15000],
                        ['slug' => 'subscription', 'label' => 'Langganan', 'price' => 13500],
                        ['slug' => 'promo', 'label' => 'Promo', 'price' => 12000],
                    ])
                    ->collapsed()
                    ->cloneable()
                    ->reorderable()
                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? 'Paket baru')
                    ->visible(fn (Get $get): bool => $get('key') === 'pricing_presets')
                    ->afterStateHydrated(function (Repeater $component, $state, Get $get): void {
                        if (filled($state)) {
                            return;
                        }

                        $decoded = json_decode((string) $get('value'), true);

                        if (is_array($decoded)) {
                            $component->state($decoded);
                        }
                    }),

                Textarea::make('value')
                    ->label('Nilai')
                    ->rows(4)
                    ->placeholder('Masukkan isi pengaturan front-end')
                    ->required(fn (Get $get): bool => $get('key') !== 'pricing_presets')
                    ->dehydrated(fn (Get $get): bool => $get('key') !== 'pricing_presets')
                    ->visible(fn (Get $get): bool => $get('key') !== 'pricing_presets'),
            ]);
    }
}
