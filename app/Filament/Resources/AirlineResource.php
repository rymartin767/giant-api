<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AirlineResource\Pages;
use App\Filament\Resources\AirlineResource\RelationManagers;
use App\Models\Airline;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AirlineResource extends Resource
{
    protected static ?string $model = Airline::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sector')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('icao')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('iata')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('union')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pilot_count')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_hiring')
                    ->required(),
                Forms\Components\TextInput::make('web_url')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->description(fn (Airline $record): string => $record->icao . ' ◦ ' . $record->iata)
                    ->searchable(),
                Tables\Columns\TextColumn::make('union')
                    ->formatStateUsing(fn (Airline $record): string => $record->union->getLabel())
                    ->description(fn (Airline $record): string => $record->sector->getLabel()),
                Tables\Columns\TextColumn::make('pilot_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_hiring')
                    ->boolean(),
                Tables\Columns\TextColumn::make('web_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAirlines::route('/'),
        ];
    }
}
