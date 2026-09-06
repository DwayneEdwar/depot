<?php

namespace App\Filament\Resources\FinancialRecords\Schemas;

use App\Models\FinancialRecord;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FinancialRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Jenis')
                    ->options([
                        FinancialRecord::TYPE_INCOME => 'Pemasukan',
                        FinancialRecord::TYPE_EXPENSE => 'Pengeluaran',
                    ])
                    ->required(),

                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'Penjualan Air' => 'Penjualan Air',
                        'Gas' => 'Gas',
                        'Filter' => 'Filter',
                        'Gaji' => 'Gaji',
                        'Perawatan' => 'Perawatan',
                        'Biaya Lainnya' => 'Biaya Lainnya',
                    ])
                    ->searchable()
                    ->required(),

                TextInput::make('amount')
                    ->label('Jumlah')
                    ->prefix('Rp')
                    ->numeric()
                    ->required(),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->columnSpanFull(),

                DatePicker::make('transaction_date')
                    ->label('Tanggal Transaksi')
                    ->required()
                    ->default(today()),
            ]);
    }
}
