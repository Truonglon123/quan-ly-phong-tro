<?php

namespace App\Filament\Resources\WaterRates\Schemas;

use App\Enums\WaterBillingMethod;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class WaterRateForm
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

                Select::make('billing_method')
                    ->label('Cách tính nước')
                    ->options(WaterBillingMethod::class)
                    ->default(WaterBillingMethod::Meter)
                    ->required()
                    ->live(),

                TextInput::make('price_per_unit')
                    ->label('Đơn giá nước')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->suffix(function (Get $get): string {
                        $method = $get('billing_method');
                        $method = $method instanceof WaterBillingMethod ? $method->value : $method;

                        return $method === 'PER_PERSON' ? '₫/người/tháng' : '₫/m³';
                    }),

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
