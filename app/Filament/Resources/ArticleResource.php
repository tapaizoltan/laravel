<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    //protected static ?string $navigationLabel = 'cikkek';
    protected static ?string $modelLabel = 'cikk';
    protected static ?string $pluralModelLabel = 'cikkek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->minLength(3)
                    ->maxLength(255),
                Forms\Components\Textarea::make('article_text')->rows(10) ->cols(20)
                    ->required(),
                Forms\Components\Select::make('tags')
                    ->multiple()
                    ->relationship(titleAttribute: 'name')
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()->unique(),]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Cikkek')->searchable()->icon('heroicon-m-newspaper'),
                Tables\Columns\TextColumn::make('tags.name')->label('Tag-ek')->icon('heroicon-m-tag')->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Szerkesztés')->link(),
                Tables\Actions\Action::make('delete')->icon('heroicon-m-trash')->color('danger')->label('Törlés')->link()->requiresConfirmation()->action(fn ($record) => $record->delete()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Mind törlése'),
                ]),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
