<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    
    protected static ?string $navigationGroup = 'Fleet Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('General Vehicle Information')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g. Toyota Hiace Commuter'),
                                        Select::make('vehicle_category_id')
                                            ->relationship('category', 'name')
                                            ->required()
                                            ->searchable(),
                                        TextInput::make('brand')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g. Toyota'),
                                        TextInput::make('model')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g. Hiace'),
                                        TextInput::make('plate_number')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g. D 1234 ABC'),
                                        TextInput::make('year')
                                            ->numeric()
                                            ->placeholder('e.g. 2022'),
                                        TextInput::make('capacity')
                                            ->numeric()
                                            ->default(4)
                                            ->required()
                                            ->placeholder('e.g. 14'),
                                        Select::make('transmission')
                                            ->options([
                                                'manual' => 'Manual',
                                                'automatic' => 'Automatic',
                                            ])
                                            ->default('manual')
                                            ->required(),
                                        TextInput::make('fuel_type')
                                            ->maxLength(255)
                                            ->placeholder('e.g. Solar / Bensin'),
                                        TextInput::make('color')
                                            ->maxLength(255)
                                            ->placeholder('e.g. Silver'),
                                    ]),
                                Textarea::make('description')
                                    ->rows(3),
                            ]),

                        Section::make('Media & Features')
                            ->columnSpan(1)
                            ->schema([
                                FileUpload::make('main_image')
                                    ->image()
                                    ->directory('vehicles')
                                    ->placeholder('Upload primary photo'),
                                TagsInput::make('features')
                                    ->placeholder('e.g. AC, Wifi, Reclining Seats')
                                    ->suggestions([
                                        'AC Dingin',
                                        'WiFi',
                                        'Karaoke',
                                        'LED TV',
                                        'USB Charger',
                                        'Reclining Seats',
                                        'Cooler Box',
                                    ]),
                            ]),

                        Section::make('Pricing Plans')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('daily_price')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->required()
                                            ->placeholder('Price per day'),
                                        TextInput::make('hourly_price')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->placeholder('Price per hour'),
                                        TextInput::make('airport_price')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->placeholder('Transfer flat price'),
                                    ]),
                            ]),

                        Section::make('Status & Documentation')
                            ->columnSpan(1)
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'available' => 'Available',
                                        'booked' => 'Booked',
                                        'on_trip' => 'On Trip',
                                        'maintenance' => 'Maintenance',
                                        'inactive' => 'Inactive',
                                    ])
                                    ->default('available')
                                    ->required(),
                                DatePicker::make('last_service_date'),
                                DatePicker::make('next_service_date'),
                                DatePicker::make('insurance_expired_at'),
                                DatePicker::make('tax_expired_at'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('main_image')
                    ->circular()
                    ->defaultImageUrl('/images/car-placeholder.png'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->sortable(),
                TextColumn::make('plate_number')
                    ->searchable(),
                TextColumn::make('capacity')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('daily_price')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'booked' => 'warning',
                        'on_trip' => 'amber',
                        'maintenance' => 'danger',
                        'inactive' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('next_service_date')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'booked' => 'Booked',
                        'on_trip' => 'On Trip',
                        'maintenance' => 'Maintenance',
                    ]),
                SelectFilter::make('vehicle_category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
