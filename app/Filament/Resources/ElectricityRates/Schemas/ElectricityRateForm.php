<?php

namespace App\Filament\Resources\ElectricityRates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ElectricityRateForm
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

                TextInput::make('price_per_unit')
                    ->label('Đơn giá điện')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->suffix('₫/kWh'),

                DatePicker::make('effective_from')
                    ->label('Áp dụng từ ngày')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now()),

                DatePicker::make('effective_to')
                    ->label('Áp dụng đến ngày')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->afterOrEqual('effective_from')
                    ->helperText('Để trống nếu giá này đang áp dụng và chưa có ngày kết thúc.')
                    ->validationMessages([
                        'after_or_equal' => 'Ngày kết thúc không được trước ngày bắt đầu.',
                    ]),

                Textarea::make('note')
                    ->label('Ghi chú')
                    ->columnSpanFull(),
            ]);
    }
}
