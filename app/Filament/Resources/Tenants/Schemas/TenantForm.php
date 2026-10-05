<?php

namespace App\Filament\Resources\Tenants\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('full_name')
                    ->label('Họ và tên')
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Số điện thoại')
                    ->tel()
                    ->required()
                    ->regex('/^0[0-9]{9}$/')
                    ->validationMessages([
                        'regex' => 'Số điện thoại phải gồm 10 chữ số và bắt đầu bằng số 0.',
                    ]),

                TextInput::make('identity_number')
                    ->label('Số CCCD/CMND')
                    ->required()
                    ->regex('/^([0-9]{9}|[0-9]{12})$/')
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'regex' => 'CCCD gồm 12 chữ số, CMND gồm 9 chữ số.',
                        'unique' => 'Số CCCD/CMND này đã tồn tại trong hệ thống.',
                    ]),

                DatePicker::make('date_of_birth')
                    ->label('Ngày sinh')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->maxDate(now()),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),

                TextInput::make('address')
                    ->label('Địa chỉ thường trú')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Textarea::make('note')
                    ->label('Ghi chú')
                    ->columnSpanFull(),
            ]);
    }
}
