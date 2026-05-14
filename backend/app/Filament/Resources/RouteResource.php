<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RouteResource\Pages;
use App\Models\Route;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class RouteResource extends Resource
{
    protected static ?string $model = Route::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Operational';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Route Details')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('origin_city')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('destination_city')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('distance_km')
                                            ->numeric()
                                            ->suffix('km')
                                            ->placeholder('e.g. 150.50'),
                                        TextInput::make('estimated_duration')
                                            ->maxLength(255)
                                            ->placeholder('e.g. 3 hours, 4h 30m'),
                                        TextInput::make('base_price')
                                            ->required()
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->placeholder('150000'),
                                        TextInput::make('slug')
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->placeholder('Auto-generated on save'),
                                    ]),
                                Textarea::make('description')
                                    ->rows(3),
                            ]),

                        Section::make('Route Status')
                            ->columnSpan(1)
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                    ])
                                    ->default('active')
                                    ->required(),
                            ]),

                        Section::make('Transit Points')
                            ->columnSpan(3)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TagsInput::make('pickup_points')
                                            ->placeholder('Add pickup point and press enter')
                                            ->helperText('Type a location (e.g. Terminal Arjosari) and press Enter'),
                                        TagsInput::make('dropoff_points')
                                            ->placeholder('Add dropoff point and press enter')
                                            ->helperText('Type a location (e.g. Bandara Juanda) and press Enter'),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('origin_city')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('destination_city')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('distance_km')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? "{$state} km" : '-'),
                TextColumn::make('estimated_duration'),
                TextColumn::make('base_price')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
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
            'index' => Pages\ListRoutes::route('/'),
            'create' => Pages\CreateRoute::route('/create'),
            'edit' => Pages\EditRoute::route('/{record}/edit'),
        ];
    }
}
