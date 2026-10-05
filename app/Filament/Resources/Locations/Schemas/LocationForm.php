<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên khu trọ')
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->label('Địa chỉ'),
                Textarea::make('description')
                    ->label('Mô tả')
                    ->columnSpanFull(),
                Select::make('user_id')
                    ->label('Chủ khu trọ')
                    ->relationship('user', 'name')
                    ->default(fn() => Auth()->id())
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
