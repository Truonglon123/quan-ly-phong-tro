<?php

namespace App\Filament\Resources\Rooms\Schemas;

use App\Enums\RoomStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('location_id')
                    ->label('Khu trọ')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('name')
                    ->label('Tên phòng')
                    ->required()
                    ->maxLength(50),

                TextInput::make('default_rent')
                    ->label('Giá thuê mặc định')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->suffix('₫'),

                TextInput::make('max_occupants')
                    ->label('Số người tối đa')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->minValue(1),

                Select::make('status')
                    ->label('Trạng thái')
                    ->options(RoomStatus::class)
                    ->default(RoomStatus::Available)
                    ->required(),

                Textarea::make('description')
                    ->label('Mô tả')
                    ->columnSpanFull(),
            ]);
    }
}
