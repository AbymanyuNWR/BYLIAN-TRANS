<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransportServiceResource\Pages;
use App\Models\TransportService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class TransportServiceResource extends Resource
{
    protected static ?string $model = TransportService::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    
    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Service Details')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g. Sewa Mobil Harian'),
                                        Select::make('service_type')
                                            ->options([
                                                'rental_car' => 'Rental Car',
                                                'airport_transfer' => 'Airport Transfer',
                                                'city_transport' => 'City Transport',
                                                'out_of_town' => 'Out of Town',
                                                'travel_route' => 'Travel Route',
                                                'tour_transport' => 'Tour Transport',
                                                'corporate_transport' => 'Corporate Transport',
                                                'charter' => 'Charter',
                                                'logistics' => 'Logistics',
                                            ])
                                            ->required(),
                                        TextInput::make('price_start_from')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->required()
                                            ->placeholder('e.g. 350000'),
                                        TextInput::make('icon')
                                            ->maxLength(255)
                                            ->placeholder('e.g. car, plane, map-pin'),
                                    ]),
                                Textarea::make('short_description')
                                    ->rows(2)
                                    ->placeholder('Short hook sentence for landing page cards'),
                                RichEditor::make('description')
                                    ->placeholder('Write full description here...'),
                                Textarea::make('terms')
                                    ->rows(3)
                                    ->placeholder('Terms and conditions specifically for this service'),
                            ]),

                        Section::make('Media & Features')
                            ->columnSpan(1)
                            ->schema([
                                FileUpload::make('image')
                                    ->image()
                                    ->directory('services')
                                    ->placeholder('Upload banner image'),
                                TagsInput::make('features')
                                    ->placeholder('Features list'),
                                TagsInput::make('includes')
                                    ->placeholder('Includes list'),
                                TagsInput::make('suitable_for')
                                    ->placeholder('Suitable for list'),
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

                        Section::make('SEO Metadata')
                            ->columnSpan(3)
                            ->collapsed()
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->maxLength(255),
                                        Textarea::make('meta_description')
                                            ->rows(2),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->circular()
                    ->defaultImageUrl('/images/service-placeholder.png'),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('service_type')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('price_start_from')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransportServices::route('/'),
            'create' => Pages\CreateTransportService::route('/create'),
            'edit' => Pages\EditTransportService::route('/{record}/edit'),
        ];
    }
}
