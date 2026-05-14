<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Finance';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Payment Order')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('booking_id')
                                            ->relationship('booking', 'booking_code')
                                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->booking_code} - {$record->customer_name} (Rp " . number_format($record->total_price, 0, ',', '.') . ")")
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        TextInput::make('payment_code')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->default(fn () => 'PAY-' . strtoupper(uniqid())),
                                        TextInput::make('amount')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->required(),
                                        Select::make('payment_method')
                                            ->options([
                                                'bank_transfer' => 'Bank Transfer',
                                                'cash' => 'Cash',
                                                'qris' => 'QRIS',
                                                'e_wallet' => 'E-Wallet',
                                                'manual' => 'Manual Input',
                                            ])
                                            ->default('bank_transfer')
                                            ->required(),
                                    ]),
                                Textarea::make('notes')
                                    ->rows(3),
                            ]),

                        Section::make('Payment Status')
                            ->columnSpan(1)
                            ->schema([
                                Select::make('payment_status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'waiting_verification' => 'Waiting Verification',
                                        'verified' => 'Verified / Paid',
                                        'rejected' => 'Rejected',
                                        'refunded' => 'Refunded',
                                    ])
                                    ->default('pending')
                                    ->required(),
                                DateTimePicker::make('paid_at'),
                            ]),

                        Section::make('Verification Proof')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('verified_by')
                                            ->relationship('verifiedBy', 'name')
                                            ->searchable()
                                            ->preload(),
                                        DateTimePicker::make('verified_at'),
                                    ]),
                                FileUpload::make('payment_proof')
                                    ->image()
                                    ->directory('payment_proofs')
                                    ->imageEditor()
                                    ->placeholder('Upload receipt / proof image'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment_code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('booking.booking_code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->badge()
                    ->color('gray'),
                ImageColumn::make('payment_proof')
                    ->square()
                    ->size(40),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'danger',
                        'waiting_verification' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        'refunded' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('paid_at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'waiting_verification' => 'Waiting Verification',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                        'refunded' => 'Refunded',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'bank_transfer' => 'Bank Transfer',
                        'cash' => 'Cash',
                        'qris' => 'QRIS',
                        'e_wallet' => 'E-Wallet',
                        'manual' => 'Manual',
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
