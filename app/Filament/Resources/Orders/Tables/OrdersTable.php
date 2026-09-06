<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('customer_name')
                    ->label('Nama Input')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('whatsapp_number')
                    ->label('WhatsApp')
                    ->searchable(),

                TextColumn::make('gallon_quantity')
                    ->label('Galon')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status Pesanan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Order::STATUS_PENDING => 'warning',
                        Order::STATUS_DELIVERING => 'info',
                        Order::STATUS_COMPLETED => 'success',
                        Order::STATUS_CANCELLED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('delivery_date')
                    ->label('Tanggal Kirim')
                    ->date()
                    ->sortable(),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('markCompleted')
                    ->label('Selesaikan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Order $record): bool => $record->status !== Order::STATUS_COMPLETED)
                    ->requiresConfirmation()
                    ->action(function (Order $record): void {
                        $record->update([
                            'status' => Order::STATUS_COMPLETED,
                        ]);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
