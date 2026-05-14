<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Finance';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Invoice Information')
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
                                        TextInput::make('invoice_number')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->default(fn () => 'INV/' . date('Ymd') . '/' . strtoupper(uniqid())),
                                        DatePicker::make('due_date'),
                                        Select::make('status')
                                            ->options([
                                                'draft' => 'Draft',
                                                'issued' => 'Issued / Sent',
                                                'paid' => 'Paid',
                                                'overdue' => 'Overdue',
                                                'cancelled' => 'Cancelled',
                                            ])
                                            ->default('draft')
                                            ->required(),
                                    ]),
                            ]),

                        Section::make('Invoice Timeline')
                            ->columnSpan(1)
                            ->schema([
                                DateTimePicker::make('issued_at'),
                                DateTimePicker::make('paid_at'),
                            ]),

                        Section::make('Financial Details')
                            ->columnSpan(3)
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextInput::make('subtotal')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->default(0)
                                            ->required(),
                                        TextInput::make('discount')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->default(0)
                                            ->required(),
                                        TextInput::make('tax')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->default(0)
                                            ->required(),
                                        TextInput::make('total')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->default(0)
                                            ->required(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('booking.booking_code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('due_date')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'issued' => 'info',
                        'paid' => 'success',
                        'overdue' => 'danger',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('issued_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'issued' => 'Issued',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                        'cancelled' => 'Cancelled',
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
