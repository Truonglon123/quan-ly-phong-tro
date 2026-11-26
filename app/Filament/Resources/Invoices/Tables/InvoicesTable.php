<?php

namespace App\Filament\Resources\Invoices\Tables;

use App\Enums\InvoiceStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Số hóa đơn')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('contract.room.name')
                    ->label('Phòng')
                    ->description(fn($record) => $record->contract?->tenant?->full_name)
                    ->searchable(),

                TextColumn::make('billing_period')
                    ->label('Kỳ')
                    ->date('m/Y')
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label('Tổng phải trả')
                    ->money('VND')
                    ->sortable(),

                TextColumn::make('due_date')
                    ->label('Hạn thanh toán')
                    ->date('d/m/Y')
                    ->placeholder('Không có')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
            ])
            ->defaultSort('billing_period', 'desc')
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options(InvoiceStatus::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
