<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Flashcard;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FlashcardResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use App\Filament\Resources\FlashcardResource\RelationManagers;
use Filament\Forms\Components\TextInput;

class FlashcardResource extends Resource
{
    protected static ?string $model = Flashcard::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('reference')
                    ->options([
                        1 => Str::of('FCOM_VOL1_LIMITATIONS')->replace('_', ' '),
                        2 => Str::of('FCOM_VOL1_NORMAL_PROCEDURES')->replace('_', ' '),
                        3 => Str::of('FCOM_VOL1_SUPPLEMENTARY_PROCEDURES')->replace('_', ' '),
                        4 => Str::of('FCOM_VOL1_SMAC')->replace('_', ' '),
                        5 => Str::of('FCOM_VOL2__CHAPTER_1_GENERAL')->replace('_', ' '),
                        6 => Str::of('FCOM_VOL2__CHAPTER_2_AIR_SYSTEMS')->replace('_', ' '),
                        7 => Str::of('FCOM_VOL2__CHAPTER_3_ANTI_ICE_RAIN')->replace('_', ' '),
                        8 => Str::of('FCOM_VOL2__CHAPTER_4_AUTOMATIC_FLIGHT')->replace('_', ' '),
                        9 => Str::of('FCOM_VOL2__CHAPTER_5_COMMUNICATIONS')->replace('_', ' '),
                        10 => Str::of('FCOM_VOL2__CHAPTER_6_ELECTRICAL')->replace('_', ' '),
                        11 => Str::of('FCOM_VOL2__CHAPTER_7_ENGINES_APU')->replace('_', ' '),
                        12 => Str::of('FCOM_VOL2__CHAPTER_8_FIRE_PROTECTION')->replace('_', ' '),
                        13 => Str::of('FCOM_VOL2__CHAPTER_9_FLIGHT_CONTROLS')->replace('_', ' '),
                        14 => Str::of('FCOM_VOL2__CHAPTER_10_FLIGHT_INSTRUMENTS_DISPLAYS')->replace('_', ' '),
                        15 => Str::of('FCOM_VOL2__CHAPTER_11_FLIGHT_MANAGEMENT_NAVIGATION')->replace('_', ' '),
                        16 => Str::of('FCOM_VOL2__CHAPTER_12_FUEL')->replace('_', ' '),
                        17 => Str::of('FCOM_VOL2__CHAPTER_13_HYDRAULICS')->replace('_', ' '),
                        18 => Str::of('FCOM_VOL2__CHAPTER_14_LANDING_GEAR')->replace('_', ' '),
                        19 => Str::of('FCOM_VOL2__CHAPTER_15_WARNING_SYSTEMS')->replace('_', ' '),
                        20 => Str::of('FOM_FLIGHT_OPERATIONS_MANUAL')->replace('_', ' '),
                    ])
                    ->columnSpan(1),
                Select::make('category')
                    ->options([
                        1 => 'LIMITATIONS',
                        2 => 'AIRCRAFT_GENERAL',
                        3 => 'AIR_SYSTEMS',
                        4 => 'ANTI_ICE',
                        5 => 'AUTOMATIC_FLIGHT',
                        6 => 'ELECTRICAL',
                        7 => 'ENGINES_APU',
                        8 => 'FIRE_PROTECTION',
                        9 => 'FLIGHT_INSTRUMENTS',
                        10 => 'FLIGHT_MANAGEMENT',
                        11 => 'FLIGHT_CONTROLS_HYDRAULICS',
                        12 => 'FUEL',
                        13 => 'WARNING_SYSTEMS',
                        14 => 'FOM',

                        45 => 'NP_11_INTRODUCTION',
                        30 => 'NP_15_PREFLIGHT',
                        31 => 'NP_20_BEFORE_START',
                        32 => 'NP_21_BEFORE_TAXI',
                        33 => 'NP_25_TAXI_OUT',
                        34 => 'NP_30_BEFORE_TAKEOFF_PROCEDURE',
                        35 => 'NP_35_TAKEOFF_PROCEDURE',
                        36 => 'NP_40_CLIMB_AND_CRUISE',
                        37 => 'NP_45_DESCENT',
                        38 => 'NP_50_APPROACH',
                        39 => 'NP_55_GO_AROUND',
                        40 => 'NP_60_LANDING',
                        41 => 'NP_65_AFTER_LANDING_PROCEDURE',
                        42 => 'NP_70_SHUTDOWN_PROCEDURE',
                        43 => 'NP_75_POSTFLIGHT_PROCEDURE',
                        44 => 'NP_80_SECURING',

                        22 => 'SMAC_80_HOLDING',
                        21 => 'SMAC_93_NON_ILS_APPROACH',
                        25 => 'SMAC_100_GO_AROUND'
                    ])->columnSpan(1),
                RichEditor::make('question')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                RichEditor::make('answer')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                FileUpload::make('question_image_url')
                    ->disk('s3-public')
                    ->directory('images/flashcards')
                    ->visibility('public')
                    ->image(),
                TextInput::make('question_image_caption'),
                FileUpload::make('answer_image_url')
                    ->disk('s3-public')
                    ->directory('images/flashcards')
                    ->visibility('public')
                    ->image(),
                TextInput::make('answer_image_caption'),
                Select::make('eicas_type')
                    ->options([
                        1 => 'WARNING',
                        2 => 'CAUTION',
                        3 => 'ADVISORY',
                        4 => 'STATUS',
                        5 => 'COMMUNICATION'
                    ]),
                Forms\Components\TextInput::make('eicas_message')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('question_image_url')
                    ->disk('s3-public')
                    ->label(''),

                TextColumn::make('category')
                    ->formatStateUsing(fn (Flashcard $record): string => $record->category->getLabel())
                    ->description(fn (Flashcard $record): string => $record->reference->getLabel())
                    ->sortable(),
                
                TextColumn::make('question')
                    ->html()
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('eicas_type')
                    ->formatStateUsing(fn (Flashcard $record): string => $record->eicas_type->name)
                    ->badge()
                    ->color(fn (Flashcard $record): string => match ($record->eicas_type->name) {
                        'CAUTION' => 'warning',
                        'ADVISORY' => 'warning',
                        'STATUS' => 'info',
                        'WARNING' => 'danger',
                        'COMMUNICATION' => 'zinc'
                    })
                    ->description(fn (Flashcard $record): string => $record->eicas_message ?? '')
                    ->label('EICAS'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListFlashcards::route('/'),
            'create' => Pages\CreateFlashcard::route('/create'),
            'edit' => Pages\EditFlashcard::route('/{record}/edit'),
        ];
    }
}
