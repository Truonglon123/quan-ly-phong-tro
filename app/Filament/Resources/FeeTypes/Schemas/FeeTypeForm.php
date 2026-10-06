<?php

namespace App\Filament\Resources\FeeTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FeeTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên loại phí')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Ví dụ: Internet, Rác, Gửi xe'),

                TextInput::make('code')
                    ->label('Mã')
                    ->required()
                    ->maxLength(50)
                    ->alphaDash()
                    ->unique(ignoreRecord: true)
                    ->dehydrateStateUsing(fn(?string $state) => $state ? strtoupper($state) : $state)
                    ->helperText('Chữ không dấu, số, gạch dưới hoặc gạch ngang. Hệ thống tự viết hoa. Ví dụ: INTERNET')
                    ->validationMessages([
                        'unique' => 'Mã này đã tồn tại.',
                        'alpha_dash' => 'Mã chỉ gồm chữ không dấu, số, gạch dưới và gạch ngang.',
                    ]),

                TextInput::make('description')
                    ->label('Mô tả')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Đang sử dụng')
                    ->default(true),
            ]);
    }
}
