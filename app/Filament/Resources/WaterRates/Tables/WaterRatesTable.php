<?php

namespace App\Filament\Resources\WaterRates\Tables;

use App\Enums\WaterBillingMethod;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WaterRatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('location.name')
                    ->label('Khu trọ')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('billing_method')
                    ->label('Cách tính')
                    ->badge(),

                TextColumn::make('price_per_unit')
                    ->label('Đơn giá')
                    ->money('VND')
                    ->suffix(fn($record) => $record->billing_method === WaterBillingMethod::PerPerson
                        ? ' /người/tháng'
                        : ' /m³')
                    ->sortable(),

                TextColumn::make('effective_from')
                    ->label('Từ ngày')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('effective_to')
                    ->label('Đến ngày')
                    ->date('d/m/Y')
                    ->placeholder('Đang áp dụng'),
            ])
            ->defaultSort('effective_from', 'desc')
            ->filters([
                SelectFilter::make('location_id')
                    ->label('Khu trọ')
                    ->relationship('location', 'name'),

                SelectFilter::make('billing_method')
                    ->label('Cách tính')
                    ->options(WaterBillingMethod::class),
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
