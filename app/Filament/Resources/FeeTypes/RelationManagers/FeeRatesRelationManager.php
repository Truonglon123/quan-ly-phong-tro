<?php

namespace App\Filament\Resources\FeeTypes\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeeRatesRelationManager extends RelationManager
{
    protected static string $relationship = 'feeRates';

    protected static ?string $title = 'Giá theo khu trọ';

    protected static ?string $modelLabel = 'mức giá';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('location_id')
                    ->label('Khu trọ')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('price')
                    ->label('Đơn giá')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->suffix('₫'),

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
                    ->helperText('Để trống nếu giá này đang áp dụng.')
                    ->validationMessages([
                        'after_or_equal' => 'Ngày kết thúc không được trước ngày bắt đầu.',
                    ]),

                Textarea::make('note')
                    ->label('Ghi chú')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('price')
            ->columns([
                TextColumn::make('location.name')
                    ->label('Khu trọ')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Đơn giá')
                    ->money('VND')
                    ->sortable(),

                TextColumn::make('effective_from')
                    ->label('Từ ngày')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('effective_to')
                    ->label('Đến ngày')
                    ->date('d/m/Y')
                    ->placeholder('Đang áp dụng'),
            ])
            ->defaultSort('effective_from', 'desc')
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
