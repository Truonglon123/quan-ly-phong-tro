<?php

namespace App\Filament\Resources\Tenants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Họ và tên')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Số điện thoại')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('identity_number')
                    ->label('CCCD/CMND')
                    ->searchable(),

                TextColumn::make('date_of_birth')
                    ->label('Ngày sinh')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->placeholder('Chưa có')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('address')
                    ->label('Địa chỉ')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
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
