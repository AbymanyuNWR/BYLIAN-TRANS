<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CharterRequestResource\Pages;
use App\Models\CharterRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CharterRequestResource extends Resource
{
    protected static ?string $model = CharterRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Operational';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Customer Contact')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('phone')
                                            ->tel()
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('email')
                                            ->email()
                                            ->maxLength(255),
                                    ]),
                            ]),

                        Section::make('Charter Status')
                            ->columnSpan(1)
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'new' => 'New Request',
                                        'contacted' => 'Contacted',
                                        'quotation_sent' => 'Quotation Sent',
                                        'negotiation' => 'In Negotiation',
                                        'converted' => 'Converted to Booking',
                                        'closed' => 'Closed',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->default('new')
                                    ->required(),
                            ]),

                        Section::make('Trip Specifications')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('trip_type')
                                            ->options([
                                                'one_way' => 'One Way',
                                                'round_trip' => 'Round Trip',
                                                'multi_day' => 'Multi Day',
                                                'city_tour' => 'City Tour',
                                                'custom' => 'Custom Trip',
                                            ])
                                            ->default('one_way')
                                            ->required(),
                                        TextInput::make('passenger_count')
                                            ->numeric()
                                            ->default(1)
                                            ->required(),
                                        DatePicker::make('departure_date')
                                            ->required(),
                                        DatePicker::make('return_date'),
                                        TextInput::make('vehicle_preference')
                                            ->placeholder('e.g. Toyota Hiace, Bus 30 seat')
                                            ->maxLength(255),
                                        TextInput::make('duration')
                                            ->placeholder('e.g. 3 days, 12 hours')
                                            ->maxLength(255),
                                        TextInput::make('estimated_budget')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->placeholder('Estimated customer budget'),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Textarea::make('pickup_location')
                                            ->required()
                                            ->rows(2),
                                        Textarea::make('destination')
                                            ->required()
                                            ->rows(2),
                                    ]),
                                Textarea::make('message')
                                    ->label('Customer Message')
                                    ->rows(3)
                                    ->placeholder('Special instructions or notes submitted by customer'),
                            ]),

                        Section::make('Administration')
                            ->columnSpan(1)
                            ->schema([
                                Textarea::make('admin_notes')
                                    ->rows(8)
                                    ->placeholder('Internal staff notes regarding quotes, conversation history, etc.'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('trip_type')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('departure_date')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('destination')
                    ->limit(30)
                    ->searchable(),
                TextColumn::make('estimated_budget')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->placeholder('-'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'contacted' => 'info',
                        'quotation_sent' => 'warning',
                        'negotiation' => 'primary',
                        'converted' => 'success',
                        'closed' => 'gray',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New Request',
                        'contacted' => 'Contacted',
                        'quotation_sent' => 'Quotation Sent',
                        'negotiation' => 'Negotiation',
                        'converted' => 'Converted',
                        'closed' => 'Closed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('trip_type')
                    ->options([
                        'one_way' => 'One Way',
                        'round_trip' => 'Round Trip',
                        'multi_day' => 'Multi Day',
                        'city_tour' => 'City Tour',
                        'custom' => 'Custom Trip',
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
            'index' => Pages\ListCharterRequests::route('/'),
            'create' => Pages\CreateCharterRequest::route('/create'),
            'edit' => Pages\EditCharterRequest::route('/{record}/edit'),
        ];
    }
}
