<?php

namespace App\Filament\Resources\InfoPosts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class InfoPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (mixed $state, Set $set): void {
                        $set('slug', Str::slug((string) $state));
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                RichEditor::make('content')
                    ->label('Konten')
                    ->required()
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'undo',
                    ]),

                Toggle::make('is_published')
                    ->label('Sudah Dipublish')
                    ->default(false),

                DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->nullable(),
            ]);
    }
}
