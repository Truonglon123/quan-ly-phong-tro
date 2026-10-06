<?php

namespace App\Filament\Resources\WaterRates;

use App\Filament\Resources\WaterRates\Pages\CreateWaterRate;
use App\Filament\Resources\WaterRates\Pages\EditWaterRate;
use App\Filament\Resources\WaterRates\Pages\ListWaterRates;
use App\Filament\Resources\WaterRates\Schemas\WaterRateForm;
use App\Filament\Resources\WaterRates\Tables\WaterRatesTable;
use App\Models\WaterRate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WaterRateResource extends Resource
{
    protected static ?string $model = WaterRate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $recordTitleAttribute = 'waterRate';

    protected static ?string $navigationLabel = 'Giá nước';

    protected static ?string $modelLabel = 'giá nước';

    protected static ?string $pluralModelLabel = 'Giá nước';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Cấu hình giá';
    }

    public static function form(Schema $schema): Schema
    {
        return WaterRateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WaterRatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWaterRates::route('/'),
            'create' => CreateWaterRate::route('/create'),
            'edit' => EditWaterRate::route('/{record}/edit'),
        ];
    }
}
