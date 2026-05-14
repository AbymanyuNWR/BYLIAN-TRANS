<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Operational';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Schedule Mapping')
                            ->description('Assign route, vehicle, and driver')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('route_id')
                                            ->relationship('route', 'origin_city')
                                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->origin_city} → {$record->destination_city} (Rp " . number_format($record->base_price, 0, ',', '.') . ")")
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Select::make('vehicle_id')
                                            ->relationship('vehicle', 'name')
                                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - {$record->plate_number} (Cap: {$record->capacity})")
                                            ->searchable()
                                            ->preload(),
                                        Select::make('driver_id')
                                            ->relationship('driver', 'name')
                                            ->searchable()
                                            ->preload(),
                                        TextInput::make('price')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->required()
                                            ->placeholder('Schedule specific price, overrides route price if set'),
                                    ]),
                            ]),

                        Section::make('Departure & Space')
                            ->columnSpan(1)
                            ->schema([
                                DatePicker::make('departure_date')
                                    ->required(),
                                TimePicker::make('departure_time')
                                    ->required(),
                                TextInput::make('arrival_estimation')
                                    ->placeholder('e.g. 15:30 or +3 hours')
                                    ->maxLength(255),
                                TextInput::make('available_seats')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                                Select::make('status')
                                    ->options([
                                        'scheduled' => 'Scheduled',
                                        'open' => 'Open For Booking',
                                        'full' => 'Full',
                                        'departed' => 'Departed',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->default('scheduled')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('route.origin_city')
                    ->label('Route')
                    ->formatStateUsing(fn ($record) => $record->route ? "{$record->route->origin_city} → {$record->route->destination_city}" : '-')
                    ->weight('bold')
                    ->searchable(query: function ($query, string $search) {
                        $query->whereHas('route', function ($q) use ($search) {
                            $q->where('origin_city', 'like', "%{$search}%")
                              ->orWhere('destination_city', 'like', "%{$search}%");
                        });
                    }),
                TextColumn::make('vehicle.name')
                    ->placeholder('No Vehicle Assigned')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('driver.name')
                    ->placeholder('No Driver Assigned')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('departure_date')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('departure_time')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('available_seats')
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('price')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'scheduled' => 'info',
                        'open' => 'success',
                        'full' => 'warning',
                        'departed' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'open' => 'Open',
                        'full' => 'Full',
                        'departed' => 'Departed',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\Filter::make('departure_date')
                    ->form([
                        DatePicker::make('departure_date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when($data['departure_date'], fn ($q, $date) => $q->whereDate('departure_date', $date));
                    }),
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
