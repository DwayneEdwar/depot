<?php

namespace App\Filament\Resources\InfoPosts;

use App\Filament\Resources\InfoPosts\Pages\CreateInfoPost;
use App\Filament\Resources\InfoPosts\Pages\EditInfoPost;
use App\Filament\Resources\InfoPosts\Pages\ListInfoPosts;
use App\Filament\Resources\InfoPosts\Schemas\InfoPostForm;
use App\Filament\Resources\InfoPosts\Tables\InfoPostsTable;
use App\Models\InfoPost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InfoPostResource extends Resource
{
    protected static ?string $model = InfoPost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?string $navigationLabel = 'Promo & Info';

    protected static ?string $modelLabel = 'Info & Promo';

    protected static ?string $pluralModelLabel = 'Info & Promo';

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return InfoPostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InfoPostsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInfoPosts::route('/'),
            'create' => CreateInfoPost::route('/create'),
            'edit' => EditInfoPost::route('/{record}/edit'),
        ];
    }
}
