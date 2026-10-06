<?php

namespace App\Filament\Resources\Rooms\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssetsRelationManager extends RelationManager
{
    protected static string $relationship = 'assets';

    protected static ?string $title = 'Tài sản trong phòng';

    protected static ?string $modelLabel = 'tài sản';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên tài sản')
                    ->required()
                    ->maxLength(255),

                TextInput::make('quantity')
                    ->label('Số lượng')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->minValue(1)
                    ->default(1),

                TextInput::make('condition')
                    ->label('Tình trạng')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Ví dụ: Mới, Hơi trầy, Hỏng nhẹ'),

                Textarea::make('note')
                    ->label('Ghi chú')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Tên tài sản')
                    ->searchable(),

                TextColumn::make('quantity')
                    ->label('Số lượng')
                    ->alignCenter(),

                TextColumn::make('condition')
                    ->label('Tình trạng'),

                TextColumn::make('note')
                    ->label('Ghi chú')
                    ->limit(40)
                    ->placeholder('Không có'),
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
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
