<?php

namespace App\Filament\Resources\Rooms;

use App\Filament\Resources\Rooms\Pages\CreateRoom;
use App\Filament\Resources\Rooms\Pages\EditRoom;
use App\Filament\Resources\Rooms\Pages\ListRooms;
use App\Filament\Resources\Rooms\RelationManagers\AssetsRelationManager;
use App\Filament\Resources\Rooms\RelationManagers\MeterReadingsRelationManager;
use App\Filament\Resources\Rooms\Schemas\RoomForm;
use App\Filament\Resources\Rooms\Tables\RoomsTable;
use App\Models\Room;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingStorefront;

    protected static ?string $recordTitleAttribute = 'room';

    protected static ?string $navigationLabel = 'Phòng trọ';

    protected static ?string $modelLabel = 'phòng trọ';

    protected static ?string $pluralModelLabel = 'Phòng trọ';

    public static function form(Schema $schema): Schema
    {
        return RoomForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RoomsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AssetsRelationManager::class,
            MeterReadingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRooms::route('/'),
            'create' => CreateRoom::route('/create'),
            'edit' => EditRoom::route('/{record}/edit'),
        ];
    }
}
