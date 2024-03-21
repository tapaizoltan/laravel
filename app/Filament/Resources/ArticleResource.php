<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

//saját use-ok
use App\Models\Article;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Radio;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $modelLabel = 'cikk';
    protected static ?string $pluralModelLabel = 'cikkek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Grid::make(4)
                ->schema([
                    Section::make() //Section::make('Ez az adott szekció címének megjelölése')
                    //->description('Ez az adott szekció címének leírása')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Cikk címe')
                            ->required()
                            ->minLength(3)
                            ->maxLength(255),

                        Forms\Components\Select::make('tags')
                            ->label('Cikk besorolása')
                            ->multiple()
                            ->relationship(titleAttribute: 'name')
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()->unique(),]),
                        ])->columnSpan(3),

                        Section::make() //Section::make('Ez az adott szekció címének gejelölése')
                        //->description('Ez az adott szekció címének leírása')
                        ->schema([
                            Forms\Components\Radio::make('published')
                            ->options([
                                '0' => 'Vázlat',
                                '1' => 'Publikált'
                            ])
                            ->default(0)
                            ->descriptions([
                                '0' => 'Így nincs publikálva a cikk.',
                                '1' => 'Elérhető a külvilág számára.'])
                            ->label('Publikálás státusza'),

                    ])->columnSpan(1),
                        
                ]), 

                Grid::make(4)
                ->schema([
                    
                    Forms\Components\RichEditor::make('article_text')
                    ->required()->label('Cikk tartalma')->columnSpan(3),
                    
                    /*
                    Forms\Components\Textarea::make('article_text')->rows(10) ->cols(20)
                    ->required()->columnSpan(3),
                    */
                ]),

            ]);
        
    }

    public static function table(Table $table): Table
    {
        return $table
            //->description('teszt') //ez egy rövid leírás a tábláról a tábla fejlécében
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Cikkek')->searchable()->icon('heroicon-m-newspaper'), // ->tooltip('Cikkek')
                Tables\Columns\TextColumn::make('tags.name')->label('Tag-ek')->searchable()->icon('heroicon-m-tag')->badge(),
                Tables\Columns\IconColumn::make('published')
                    ->icon(fn (string $state): string => match ($state) {
                        '0' => 'heroicon-o-pencil',
                        '1' => 'heroicon-o-check-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'info',
                        '1' => 'success',
                        //default => 'gray',
                    })
                    ->label('Státusz')
                    ->size('md'),
            ])
            ->filters([
                Tables\Filters\Filter::make('published')
                    ->query(fn (Builder $query) => $query->where('published', true)),
                    Tables\Filters\SelectFilter::make('published')
                    ->label('Publikálás státusza')
                    ->options([
                        '0' => 'Vázlat',
                        '1' => 'Publikált',
                    ]),
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
