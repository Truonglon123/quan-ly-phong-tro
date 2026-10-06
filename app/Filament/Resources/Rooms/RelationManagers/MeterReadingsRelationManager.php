<?php

namespace App\Filament\Resources\Rooms\RelationManagers;

use App\Enums\MeterType;
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
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MeterReadingsRelationManager extends RelationManager
{
    protected static string $relationship = 'meterReadings';

    protected static ?string $title = 'Chỉ số điện nước';

    protected static ?string $modelLabel = 'chỉ số';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('meter_type')
                    ->label('Loại đồng hồ')
                    ->options(MeterType::class)
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set, RelationManager $livewire) {
                        $type = $state instanceof MeterType ? $state->value : $state;

                        $last = $livewire->getOwnerRecord()
                            ->meterReadings()
                            ->where('meter_type', $type)
                            ->orderByDesc('reading_date')
                            ->orderByDesc('id')
                            ->first();

                        $set('previous_reading', $last?->current_reading ?? 0);
                    }),

                DatePicker::make('reading_date')
                    ->label('Ngày ghi')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now()),

                TextInput::make('previous_reading')
                    ->label('Chỉ số cũ')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Get $get, Set $set) => $set(
                        'consumption',
                        round((float) $get('current_reading') - (float) $get('previous_reading'), 3)
                    )),

                TextInput::make('current_reading')
                    ->label('Chỉ số mới')
                    ->required()
                    ->numeric()
                    ->gte('previous_reading')
                    ->validationMessages([
                        'gte' => 'Chỉ số mới phải lớn hơn hoặc bằng chỉ số cũ.',
                    ])
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Get $get, Set $set) => $set(
                        'consumption',
                        round((float) $get('current_reading') - (float) $get('previous_reading'), 3)
                    )),

                TextInput::make('consumption')
                    ->label('Mức tiêu thụ')
                    ->disabled()
                    ->dehydrated(false),

                Textarea::make('note')
                    ->label('Ghi chú')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('reading_date')
            ->columns([
                TextColumn::make('reading_date')
                    ->label('Ngày ghi')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('meter_type')
                    ->label('Loại')
                    ->badge(),

                TextColumn::make('previous_reading')
                    ->label('Chỉ số cũ')
                    ->numeric(decimalPlaces: 3),

                TextColumn::make('current_reading')
                    ->label('Chỉ số mới')
                    ->numeric(decimalPlaces: 3),

                TextColumn::make('consumption')
                    ->label('Tiêu thụ')
                    ->numeric(decimalPlaces: 3)
                    ->suffix(fn($record) => ' ' . $record->meter_type->unit()),
            ])
            ->defaultSort('reading_date', 'desc')
            ->filters([
                SelectFilter::make('meter_type')
                    ->label('Loại')
                    ->options(MeterType::class),
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
