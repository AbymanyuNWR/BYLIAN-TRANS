<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\WhatsappSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    
    protected static ?string $navigationGroup = 'Operational';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Customer Information')
                            ->description('Contact details of the client')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('customer_name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('customer_phone')
                                            ->tel()
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('customer_email')
                                            ->email()
                                            ->maxLength(255),
                                        Select::make('customer_id')
                                            ->relationship('customer', 'name')
                                            ->searchable()
                                            ->placeholder('Optional registered customer link'),
                                    ]),
                            ]),

                        Section::make('Meta Information')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('booking_code')
                                    ->disabled()
                                    ->placeholder('Auto-generated code')
                                    ->dehydrated(false),
                                Select::make('source')
                                    ->options([
                                        'website' => 'Website',
                                        'whatsapp' => 'WhatsApp',
                                        'admin_input' => 'Admin Input',
                                        'manual' => 'Manual',
                                    ])
                                    ->default('admin_input')
                                    ->required(),
                            ]),

                        Section::make('Service & Routing')
                            ->description('Service type, routes, and schedules')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('service_id')
                                            ->relationship('service', 'title')
                                            ->required()
                                            ->searchable(),
                                        Select::make('route_id')
                                            ->relationship('route', 'origin_city', function (Builder $query) {
                                                return $query; // standard route
                                            })
                                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->origin_city} - {$record->destination_city}")
                                            ->searchable()
                                            ->placeholder('Optional Route link'),
                                        Select::make('schedule_id')
                                            ->relationship('schedule', 'id', function (Builder $query) {
                                                return $query;
                                            })
                                            ->getOptionLabelFromRecordUsing(fn ($record) => "Departure: {$record->departure_date->format('d M Y')} - {$record->departure_time}")
                                            ->searchable()
                                            ->placeholder('Optional Schedule link'),
                                        TextInput::make('passenger_count')
                                            ->numeric()
                                            ->default(1)
                                            ->required(),
                                    ]),
                            ]),

                        Section::make('Pricing & Status')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('total_price')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                                Select::make('booking_status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'confirmed' => 'Confirmed',
                                        'assigned' => 'Assigned',
                                        'on_trip' => 'On Trip',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                        'rejected' => 'Rejected',
                                    ])
                                    ->default('pending')
                                    ->required(),
                                Select::make('payment_status')
                                    ->options([
                                        'unpaid' => 'Unpaid',
                                        'waiting_verification' => 'Waiting Verification',
                                        'paid' => 'Paid',
                                        'partial_paid' => 'Partial Paid',
                                        'refunded' => 'Refunded',
                                        'failed' => 'Failed',
                                    ])
                                    ->default('unpaid')
                                    ->required(),
                            ]),

                        Section::make('Pickup & Dispatch Details')
                            ->description('Schedules, assigned vehicle, and driver')
                            ->columnSpan(3)
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        DatePicker::make('pickup_date')
                                            ->required(),
                                        TimePicker::make('pickup_time')
                                            ->required(),
                                        Select::make('vehicle_id')
                                            ->relationship('vehicle', 'name')
                                            ->placeholder('Select Fleet Vehicle'),
                                        Select::make('driver_id')
                                            ->relationship('driver', 'name')
                                            ->placeholder('Assign Driver'),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Textarea::make('pickup_location')
                                            ->required()
                                            ->rows(2),
                                        Textarea::make('dropoff_location')
                                            ->required()
                                            ->rows(2),
                                    ]),
                                Textarea::make('notes')
                                    ->rows(2),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),
                TextColumn::make('customer_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_phone')
                    ->searchable(),
                TextColumn::make('service.title')
                    ->sortable()
                    ->limit(20),
                TextColumn::make('pickup_date')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('total_price')
                    ->money('IDR', true)
                    ->sortable(),
                TextColumn::make('booking_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'assigned' => 'gray',
                        'on_trip' => 'amber',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'gray',
                        'waiting_verification' => 'warning',
                        'paid' => 'success',
                        'partial_paid' => 'info',
                        'refunded' => 'danger',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('booking_status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'assigned' => 'Assigned',
                        'on_trip' => 'On Trip',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        'rejected' => 'Rejected',
                    ]),
                SelectFilter::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'waiting_verification' => 'Waiting Verification',
                        'paid' => 'Paid',
                        'refunded' => 'Refunded',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('downloadInvoice')
                    ->label('Invoice PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('warning')
                    ->url(fn (Booking $record) => route('booking.invoice.pdf', $record))
                    ->openUrlInNewTab(),
                Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (Booking $record) {
                        $phone = preg_replace('/[^0-9]/', '', $record->customer_phone);
                        if (str_starts_with($phone, '0')) {
                            $phone = '62' . substr($phone, 1);
                        }
                        
                        $setting = WhatsappSetting::first();
                        $template = $setting?->booking_message ?? "Halo {customer_name}, kami ingin mengonfirmasi booking Anda.";
                        
                        $message = strtr($template, [
                            '{booking_code}' => $record->booking_code,
                            '{customer_name}' => $record->customer_name,
                            '{service_title}' => $record->service?->title ?? 'Layanan Transportasi',
                            '{pickup_date}' => $record->pickup_date->format('d M Y'),
                            '{pickup_time}' => $record->pickup_time,
                            '{pickup_location}' => $record->pickup_location,
                            '{dropoff_location}' => $record->dropoff_location,
                            '{total_price}' => 'Rp ' . number_format($record->total_price, 0, ',', '.'),
                        ]);
                        
                        return "https://wa.me/{$phone}?text=" . urlencode($message);
                    })
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
