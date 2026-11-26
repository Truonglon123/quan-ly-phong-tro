<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\TextColumn;

use App\Enums\InvoiceItemType;
use App\Models\FeeRate;
use App\Models\MeterReading;

class InvoiceItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'invoiceItems';

    protected static ?string $title = 'Các khoản trên hóa đơn';

    protected static ?string $modelLabel = 'khoản';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('item_type')
                    ->label('Loại khoản')
                    ->options(InvoiceItemType::class)
                    ->required()
                    ->live(),

                TextInput::make('description')
                    ->label('Diễn giải')
                    ->required()
                    ->maxLength(255),

                Select::make('meter_reading_id')
                    ->label('Chỉ số đồng hồ')
                    ->visible(fn(Get $get) => in_array(self::typeValue($get('item_type')), ['ELECTRICITY', 'WATER']))
                    ->options(function (RelationManager $livewire) {
                        $roomId = $livewire->getOwnerRecord()->contract->room_id;

                        return MeterReading::where('room_id', $roomId)
                            ->orderByDesc('reading_date')
                            ->get()
                            ->mapWithKeys(fn(MeterReading $r) => [
                                $r->id => $r->reading_date->format('d/m/Y') . ' - ' . $r->meter_type->getLabel() . ' - ' . (float) $r->consumption . ' ' . $r->meter_type->unit(),
                            ]);
                    })
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set) {
                        $reading = MeterReading::find($state);

                        if ($reading) {
                            $set('quantity', (float) $reading->consumption);
                        }
                    })
                    ->helperText('Chọn lần ghi chỉ số để tự điền số lượng.'),

                Select::make('fee_rate_id')
                    ->label('Mức giá phí')
                    ->visible(fn(Get $get) => in_array(self::typeValue($get('item_type')), ['INTERNET', 'TRASH', 'PARKING', 'OTHER']))
                    ->options(function (RelationManager $livewire) {
                        $locationId = $livewire->getOwnerRecord()->contract->room->location_id;

                        return FeeRate::with('feeType')
                            ->where('location_id', $locationId)
                            ->where(fn($q) => $q->whereNull('effective_to')->orWhere('effective_to', '>=', now()))
                            ->get()
                            ->mapWithKeys(fn(FeeRate $r) => [
                                $r->id => $r->feeType->name . ' - ' . number_format((float) $r->price, 0, ',', '.') . ' ₫',
                            ]);
                    })
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set) {
                        $rate = FeeRate::find($state);

                        if ($rate) {
                            $set('unit_price', (float) $rate->price);
                        }
                    })
                    ->helperText('Chỉ hiện các mức giá đang áp dụng của khu trọ này.'),

                TextInput::make('quantity')
                    ->label('Số lượng')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(1),

                TextInput::make('unit_price')
                    ->label('Đơn giá')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->suffix('₫'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('item_type')
                    ->label('Loại')
                    ->badge(),

                TextColumn::make('description')
                    ->label('Diễn giải'),

                TextColumn::make('quantity')
                    ->label('Số lượng')
                    ->formatStateUsing(fn($state) => rtrim(rtrim(number_format((float) $state, 3, ',', '.'), '0'), ',')),

                TextColumn::make('unit_price')
                    ->label('Đơn giá')
                    ->money('VND'),

                TextColumn::make('amount')
                    ->label('Thành tiền')
                    ->money('VND'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                // DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function typeValue(mixed $state): ?string
    {
        return $state instanceof InvoiceItemType ? $state->value : $state;
    }
}
