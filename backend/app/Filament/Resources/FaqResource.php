<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('FAQ Content')
                            ->columnSpan(2)
                            ->schema([
                                TextInput::make('question')
                                    ->required()
                                    ->maxLength(255),
                                RichEditor::make('answer')
                                    ->required()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'bulletList',
                                        'orderedList',
                                        'link',
                                        'undo',
                                        'redo',
                                    ]),
                            ]),

                        Section::make('FAQ Settings')
                            ->columnSpan(1)
                            ->schema([
                                Select::make('category')
                                    ->options([
                                        'General' => 'General',
                                        'Booking' => 'Booking',
                                        'Pembayaran' => 'Pembayaran (Payment)',
                                        'Pembatalan' => 'Pembatalan (Cancellation)',
                                        'Sewa Mobil' => 'Sewa Mobil (Car Rental)',
                                        'Travel' => 'Travel',
                                        'Driver' => 'Driver',
                                        'Bagasi' => 'Bagasi (Luggage)',
                                        'Jadwal' => 'Jadwal (Schedule)',
                                    ])
                                    ->default('General')
                                    ->required(),
                                Select::make('status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                    ])
                                    ->default('active')
                                    ->required(),
                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),
                TextColumn::make('category')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'General' => 'General',
                        'Booking' => 'Booking',
                        'Pembayaran' => 'Pembayaran',
                        'Pembatalan' => 'Pembatalan',
                        'Sewa Mobil' => 'Sewa Mobil',
                        'Travel' => 'Travel',
                        'Driver' => 'Driver',
                        'Bagasi' => 'Bagasi',
                        'Jadwal' => 'Jadwal',
                    ]),
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
