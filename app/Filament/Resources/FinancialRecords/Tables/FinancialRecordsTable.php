<?php

namespace App\Filament\Resources\FinancialRecords\Tables;

use App\Models\FinancialRecord;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FinancialRecordsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Jenis')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        FinancialRecord::TYPE_INCOME => 'Pemasukan',
                        FinancialRecord::TYPE_EXPENSE => 'Pengeluaran',
                        default => 'Lainnya',
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        FinancialRecord::TYPE_INCOME => 'success',
                        FinancialRecord::TYPE_EXPENSE => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(40)
                    ->searchable(),
            ])
            ->filters([
                Filter::make('transaction_date')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('to'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $query, $date) => $query->whereDate('transaction_date', '>=', $date))
                            ->when($data['to'] ?? null, fn (Builder $query, $date) => $query->whereDate('transaction_date', '<=', $date));
                    }),
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
