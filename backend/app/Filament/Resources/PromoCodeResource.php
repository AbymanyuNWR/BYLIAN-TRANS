<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoCodeResource\Pages;
use App\Models\PromoCode;
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

class PromoCodeResource extends Resource
{
    protected static ?string $model = PromoCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Operational';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Coupon Code')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('code')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->placeholder('e.g. MUDIK2026')
                                            ->dehydrateStateUsing(fn ($state) => strtoupper($state)),
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Select::make('discount_type')
                                            ->options([
                                                'percentage' => 'Percentage (%)',
                                                'fixed' => 'Fixed Amount (Rp)',
                                            ])
                                            ->default('percentage')
                                            ->required()
                                            ->live(),
                                        TextInput::make('discount_value')
                                            ->numeric()
                                            ->required()
                                            ->prefix(fn (Forms\Get $get) => $get('discount_type') === 'fixed' ? 'Rp' : null)
                                            ->suffix(fn (Forms\Get $get) => $get('discount_type') === 'percentage' ? '%' : null),
                                    ]),
                                Textarea::make('description')
                                    ->rows(3),
                            ]),

                        Section::make('Usage Settings')
                            ->columnSpan(1)
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                    ])
                                    ->default('active')
                                    ->required(),
                                DatePicker::make('start_date'),
                                DatePicker::make('end_date'),
                            ]),

                        Section::make('Limits & Conditions')
                            ->columnSpan(3)
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextInput::make('max_discount')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->placeholder('e.g. Max discount limit')
                                            ->helperText('Only for Percentage discount type'),
                                        TextInput::make('minimum_order')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->default(0)
                                            ->required(),
                                        TextInput::make('usage_limit')
                                            ->numeric()
                                            ->placeholder('Unlimited if left blank'),
                                        TextInput::make('used_count')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled()
                                            ->dehydrated(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('discount_value')
                    ->formatStateUsing(function ($record) {
                        return $record->discount_type === 'percentage' 
                            ? "{$record->discount_value}%" 
                            : "Rp " . number_format($record->discount_value, 0, ',', '.');
                    })
                    ->sortable(),
                TextColumn::make('minimum_order')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('used_count')
                    ->alignCenter()
                    ->formatStateUsing(fn ($record) => $record->usage_limit ? "{$record->used_count} / {$record->usage_limit}" : "{$record->used_count} / ∞")
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date('d M Y')
                    ->placeholder('Never Expires')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        default => 'gray',
                    }),
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
            'index' => Pages\ListPromoCodes::route('/'),
            'create' => Pages\CreatePromoCode::route('/create'),
            'edit' => Pages\EditPromoCode::route('/{record}/edit'),
        ];
    }
}
