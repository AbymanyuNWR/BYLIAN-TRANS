<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhatsappSettingResource\Pages;
use App\Models\WhatsappSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class WhatsappSettingResource extends Resource
{
    protected static ?string $model = WhatsappSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    
    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Section::make('General Contact')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('phone_number')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g. 081234567890'),
                                        Toggle::make('is_active')
                                            ->default(true),
                                    ]),
                                Textarea::make('default_message')
                                    ->rows(3)
                                    ->placeholder('Default message when clicking the WhatsApp bubble'),
                            ]),

                        Section::make('Message Templates')
                            ->description('Use placeholders like {booking_code}, {customer_name}, {total_price} in templates.')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Textarea::make('booking_message')
                                            ->rows(5)
                                            ->label('Booking Confirmation Template'),
                                        Textarea::make('charter_message')
                                            ->rows(5)
                                            ->label('Charter Inquiry Template'),
                                        Textarea::make('payment_message')
                                            ->rows(5)
                                            ->label('Payment Invoice Template'),
                                        Textarea::make('driver_message')
                                            ->rows(5)
                                            ->label('Driver Dispatch Template'),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('phone_number')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('default_message')
                    ->limit(50),
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
            'index' => Pages\ListWhatsappSettings::route('/'),
            'create' => Pages\CreateWhatsappSetting::route('/create'),
            'edit' => Pages\EditWhatsappSetting::route('/{record}/edit'),
        ];
    }
}
