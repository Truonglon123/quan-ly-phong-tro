<?php

namespace App\Filament\Resources\ElectricityRates;

use App\Filament\Resources\ElectricityRates\Pages\CreateElectricityRate;
use App\Filament\Resources\ElectricityRates\Pages\EditElectricityRate;
use App\Filament\Resources\ElectricityRates\Pages\ListElectricityRates;
use App\Filament\Resources\ElectricityRates\Schemas\ElectricityRateForm;
use App\Filament\Resources\ElectricityRates\Tables\ElectricityRatesTable;
use App\Models\ElectricityRate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ElectricityRateResource extends Resource
{
    protected static ?string $model = ElectricityRate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $recordTitleAttribute = 'electricityRate';

    protected static ?string $navigationLabel = 'Giá điện';

    protected static ?string $modelLabel = 'giá điện';

    protected static ?string $pluralModelLabel = 'Giá điện';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'Cấu hình giá';
    }

    public static function form(Schema $schema): Schema
    {
        return ElectricityRateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ElectricityRatesTable::configure($table);
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
            'index' => ListElectricityRates::route('/'),
            'create' => CreateElectricityRate::route('/create'),
            'edit' => EditElectricityRate::route('/{record}/edit'),
        ];
    }
}
