<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    //protected static ?string $navigationLabel = 'Hozzászólások';
    protected static ?string $modelLabel = 'hozzászólás';
    protected static ?string $pluralModelLabel = 'hozzászólások';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->minLength(3)
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                /*
                Ezzel csak az article_id-t íratom ki.
                */
                //Tables\Columns\TextColumn::make('article_id'), 

                /*
                Ezzel a az article title íratom ki, úgy, hogy az artical mögé írom a title-t egy pontal elválasztva.
                Ez azért lehetséges mert már modul szinten összefűztem a comment-et az article-el
                */
                Tables\Columns\TextColumn::make('name')->label('Hozzászólások')->searchable()->icon('heroicon-m-chat-bubble-bottom-center-text'),
                Tables\Columns\TextColumn::make('article.title')->label('Cikkek')->icon('heroicon-m-newspaper'),
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
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
