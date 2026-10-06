<?php

namespace App\Filament\Resources\ElectricityRates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ElectricityRatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('location.name')
                    ->label('Khu trọ')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price_per_unit')
                    ->label('Đơn giá')
                    ->money('VND')
                    ->suffix(' /kWh')
                    ->sortable(),

                TextColumn::make('effective_from')
                    ->label('Từ ngày')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('effective_to')
                    ->label('Đến ngày')
                    ->date('d/m/Y')
                    ->placeholder('Đang áp dụng'),

                TextColumn::make('note')
                    ->label('Ghi chú')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('effective_from', 'desc')
            ->filters([
                SelectFilter::make('location_id')
                    ->label('Khu trọ')
                    ->relationship('location', 'name'),
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
