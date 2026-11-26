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
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Enums\PaymentMethod;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $title = 'Thanh toán';

    protected static ?string $modelLabel = 'khoản thanh toán';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')
                    ->label('Số tiền')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->suffix('₫'),

                Select::make('payment_method')
                    ->label('Phương thức')
                    ->options(PaymentMethod::class)
                    ->default(PaymentMethod::Cash)
                    ->required(),

                DatePicker::make('paid_at')
                    ->label('Ngày thanh toán')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now())
                    ->maxDate(now()),

                TextInput::make('reference')
                    ->label('Mã giao dịch')
                    ->maxLength(255)
                    ->helperText('Mã giao dịch ngân hàng, để trống nếu trả tiền mặt.'),

                Textarea::make('note')
                    ->label('Ghi chú')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('paid_at')
            ->columns([
                TextColumn::make('paid_at')
                    ->label('Ngày')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Số tiền')
                    ->money('VND')
                    ->summarize(
                        \Filament\Tables\Columns\Summarizers\Sum::make()
                            ->label('Tổng đã trả')
                            ->money('VND')
                    ),

                TextColumn::make('payment_method')
                    ->label('Phương thức')
                    ->badge(),

                TextColumn::make('reference')
                    ->label('Mã giao dịch')
                    ->placeholder('Không có'),
            ])
            ->defaultSort('paid_at', 'desc')
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
}
