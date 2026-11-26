<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Enums\InvoiceStatus;
use App\Models\Contract;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_number')
                    ->label('Số hóa đơn')
                    ->required()
                    ->maxLength(50)
                    ->default(fn() => 'HD-' . now()->format('Ym') . '-' . strtoupper(Str::random(4)))
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Số hóa đơn này đã tồn tại.',
                    ]),

                Select::make('status')
                    ->label('Trạng thái')
                    ->options(InvoiceStatus::class)
                    ->default(InvoiceStatus::Draft)
                    ->required(),

                Select::make('contract_id')
                    ->label('Hợp đồng')
                    ->relationship(
                        name: 'contract',
                        titleAttribute: 'contract_number',
                        modifyQueryUsing: fn(Builder $query) => $query->with(['room', 'tenant']),
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn(Contract $record) => "{$record->contract_number} - {$record->room->name} - {$record->tenant->full_name}"
                    )
                    ->searchable(['contract_number'])
                    ->preload()
                    ->required(),

                DatePicker::make('billing_period')
                    ->label('Kỳ hóa đơn')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now()->startOfMonth())
                    ->helperText('Chọn ngày đầu tháng của kỳ tính, ví dụ 01/10/2026 cho tháng 10.'),

                DatePicker::make('issued_at')
                    ->label('Ngày lập')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now()),

                DatePicker::make('due_date')
                    ->label('Hạn thanh toán')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->afterOrEqual('issued_at')
                    ->validationMessages([
                        'after_or_equal' => 'Hạn thanh toán không được trước ngày lập.',
                    ]),

                TextInput::make('discount')
                    ->label('Giảm giá')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->suffix('₫'),

                TextInput::make('subtotal')
                    ->label('Tổng các khoản')
                    ->disabled()
                    ->dehydrated(false)
                    ->hiddenOn('create')
                    ->formatStateUsing(fn($state) => number_format((float) $state, 0, ',', '.'))
                    ->suffix('₫'),

                TextInput::make('total_amount')
                    ->label('Tổng phải trả')
                    ->disabled()
                    ->dehydrated(false)
                    ->hiddenOn('create')
                    ->formatStateUsing(fn($state) => number_format((float) $state, 0, ',', '.'))
                    ->suffix('₫'),

                Textarea::make('note')
                    ->label('Ghi chú')
                    ->columnSpanFull(),
            ]);
    }
}
