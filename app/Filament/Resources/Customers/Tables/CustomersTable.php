<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('whatsapp_number')
                    ->label('WhatsApp')
                    ->searchable(),

                TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(50)
                    ->searchable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('loyal_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Loyal' ? 'success' : 'gray')
                    ->sortable(false),

                TextColumn::make('order_count')
                    ->label('Jumlah Order')
                    ->sortable(),

                TextColumn::make('points')
                    ->label('Poin')
                    ->sortable(),

                TextColumn::make('total_gallon')
                    ->label('Total Galon')
                    ->sortable(),

                TextColumn::make('total_purchase')
                    ->label('Total Belanja')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Terakhir diubah')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
