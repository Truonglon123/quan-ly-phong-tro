<?php

namespace App\Filament\Resources\Contracts\Schemas;

use App\Enums\ContractStatus;
use App\Enums\WaterBillingMethod;
use App\Models\Room;
use App\Models\Tenant;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class ContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('contract_number')
                    ->label('Số hợp đồng')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Số hợp đồng này đã tồn tại.',
                    ]),

                Select::make('status')
                    ->label('Trạng thái')
                    ->options(ContractStatus::class)
                    ->default(ContractStatus::Draft)
                    ->required(),

                Select::make('room_id')
                    ->label('Phòng')
                    ->relationship(
                        name: 'room',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => $query->with('location'),
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn(Room $record) => "{$record->location->name} - {$record->name}"
                    )
                    ->searchable(['name'])
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set) {
                        $room = Room::find($state);

                        if ($room) {
                            $set('agreed_rent', $room->default_rent);
                            $set('max_occupants', $room->max_occupants);
                        }
                    }),

                Select::make('tenant_id')
                    ->label('Người đứng tên')
                    ->relationship('tenant', 'full_name')
                    ->getOptionLabelFromRecordUsing(
                        fn(Tenant $record) => "{$record->full_name} - {$record->phone} - CCCD ..." . substr($record->identity_number, -4)
                    )
                    ->searchable(['full_name', 'phone', 'identity_number'])
                    ->preload()
                    ->required(),

                DatePicker::make('start_date')
                    ->label('Ngày bắt đầu')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now()),

                DatePicker::make('end_date')
                    ->label('Ngày kết thúc')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->after('start_date')
                    ->validationMessages([
                        'after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
                    ]),

                TextInput::make('agreed_rent')
                    ->label('Giá thuê thực tế')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->suffix('₫'),

                TextInput::make('deposit_amount')
                    ->label('Tiền cọc')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->suffix('₫'),

                TextInput::make('max_occupants')
                    ->label('Số người tối đa')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->minValue(1),

                Select::make('water_billing_method')
                    ->label('Cách tính nước')
                    ->options(WaterBillingMethod::class)
                    ->default(WaterBillingMethod::Meter)
                    ->required(),

                Textarea::make('note')
                    ->label('Ghi chú')
                    ->columnSpanFull(),
            ]);
    }
}
