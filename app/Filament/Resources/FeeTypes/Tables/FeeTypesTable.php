<?php

namespace App\Filament\Resources\FeeTypes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeeTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên loại phí')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('code')
                    ->label('Mã')
                    ->badge()
                    ->searchable(),

                TextColumn::make('fee_rates_count')
                    ->label('Số mức giá')
                    ->counts('feeRates')
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Đang dùng')
                    ->boolean(),
            ])
            ->filters([
                //
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
