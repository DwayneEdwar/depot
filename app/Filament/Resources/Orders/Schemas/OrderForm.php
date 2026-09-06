<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Customer;
use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->label('Pelanggan')
                    ->options(Customer::query()->orderBy('name')->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->placeholder('Pilih pelanggan / isi manual')
                    ->nullable()
                    ->live()
                    ->afterStateUpdated(function (mixed $state, Set $set): void {
                        if (! $state) {
                            return;
                        }

                        $customer = Customer::find($state);

                        if (! $customer) {
                            return;
                        }

                        $set('customer_name', $customer->name);
                        $set('whatsapp_number', $customer->whatsapp_number);
                        $set('address', $customer->address);
                    }),

                TextInput::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->maxLength(255),

                TextInput::make('whatsapp_number')
                    ->label('Nomor WhatsApp')
                    ->required()
                    ->tel()
                    ->maxLength(20),

                Textarea::make('address')
                    ->label('Alamat Pengiriman')
                    ->required()
                    ->rows(4),

                TextInput::make('gallon_quantity')
                    ->label('Jumlah Galon')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->live(debounce: 300)
                    ->afterStateUpdated(function (mixed $state, Set $set): void {
                        $quantity = (int) ($state ?? 0);
                        $set('total_price', $quantity * 15000);
                    }),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        Order::STATUS_PENDING => 'Pending',
                        Order::STATUS_DELIVERING => 'Delivering',
                        Order::STATUS_COMPLETED => 'Completed',
                        Order::STATUS_CANCELLED => 'Cancelled',
                    ])
                    ->default(Order::STATUS_PENDING)
                    ->required(),

                DatePicker::make('delivery_date')
                    ->label('Tanggal Pengiriman')
                    ->required(),

                TextInput::make('total_price')
                    ->label('Total Harga')
                    ->prefix('Rp')
                    ->numeric()
                    ->readOnly()
                    ->dehydrated()
                    ->default(0),
            ]);
    }
}
