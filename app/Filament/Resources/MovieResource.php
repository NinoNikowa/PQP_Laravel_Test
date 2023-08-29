<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Models\Movie;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(
                    'Titre du film')->schema([
                        TextInput::make('title')->required()->label(''),
                        Checkbox::make('is_trending')->label('Film tendance'),
                    ]),
                Textarea::make('overview')->label('Description')->rows(10),

                Group::make([
                    DatePicker::make('release_date')->label('Date de sortie'),
                    TextInput::make('tagline')->label('Accroche'),
                    TextInput::make('homepage')->label('Lien')->placeholder(''),
                    TextInput::make('poster_path')->label('Chemin vers la photo'),
                ]),
                Section::make(
                    'Genres')->schema([
                        Select::make('moviesGenres')
                            ->label('')
                            ->multiple()
                            ->relationship('moviesGenres', 'name'),
                    ]),
                Section::make(
                    'Mise à jour automatique')->schema([
                        Checkbox::make('disable_sync')
                            ->label('Désactiver la mise à jour automatique')
                            ->helperText("Evite d'écraser vos modifications lors de la synchronisation journalière."),
                    ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                ImageColumn::make('poster')->label('Poster'),
                TextColumn::make('title')->label('Titre du film')->weight(FontWeight::Bold)->sortable()->searchable(),
                TextColumn::make('moviesGenres.name')->label('Genres'),
            ])
            ->filters([
                Filter::make('is_trending')->default(true)->label('Film tendances uniquement'),
                SelectFilter::make('moviesGenres')
                    ->relationship('moviesGenres', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
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
            'index' => Pages\ListMovies::route('/'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }
}
