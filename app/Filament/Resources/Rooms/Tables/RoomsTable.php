<?php

namespace App\Filament\Resources\Rooms\Tables;

use App\Enums\RoomStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RoomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('location.name')
                    ->label('Khu trọ')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Tên phòng')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('default_rent')
                    ->label('Giá thuê')
                    ->money('VND')
                    ->sortable(),

                TextColumn::make('max_occupants')
                    ->label('Số người tối đa')
                    ->alignCenter(),

                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('location_id')
                    ->label('Khu trọ')
                    ->relationship('location', 'name'),

                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options(RoomStatus::class),
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
