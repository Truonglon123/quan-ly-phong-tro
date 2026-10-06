<?php

namespace App\Filament\Resources\Contracts\RelationManagers;

use App\Models\Tenant;
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

class ContractOccupantsRelationManager extends RelationManager
{
    protected static string $relationship = 'contractOccupants';

    protected static ?string $title = 'Người ở cùng';

    protected static ?string $modelLabel = 'người ở cùng';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tenant_id')
                    ->label('Người ở cùng')
                    ->relationship('tenant', 'full_name')
                    ->getOptionLabelFromRecordUsing(
                        fn(Tenant $record) => "{$record->full_name} - {$record->phone} - CCCD ..." . substr($record->identity_number, -4)
                    )
                    ->searchable(['full_name', 'phone', 'identity_number'])
                    ->preload()
                    ->required(),

                DatePicker::make('start_date')
                    ->label('Ngày bắt đầu ở')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now()),

                DatePicker::make('end_date')
                    ->label('Ngày dọn đi')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->after('start_date')
                    ->validationMessages([
                        'after' => 'Ngày dọn đi phải sau ngày bắt đầu ở.',
                    ]),

                Textarea::make('note')
                    ->label('Ghi chú')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tenant_id')
            ->columns([
                TextColumn::make('tenant.full_name')
                    ->label('Họ và tên')
                    ->searchable(),

                TextColumn::make('tenant.phone')
                    ->label('Số điện thoại'),

                TextColumn::make('start_date')
                    ->label('Ở từ ngày')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Dọn đi ngày')
                    ->date('d/m/Y')
                    ->placeholder('Đang ở'),
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
}
