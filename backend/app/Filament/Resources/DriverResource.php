<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationGroup = 'Fleet Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Driver Bio-data')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g. Agus Santoso'),
                                        TextInput::make('phone')
                                            ->tel()
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g. 0812-1111-2222'),
                                        TextInput::make('email')
                                            ->email()
                                            ->maxLength(255)
                                            ->placeholder('e.g. agus@byliantransportasi.com'),
                                        Select::make('user_id')
                                            ->relationship('user', 'name')
                                            ->searchable()
                                            ->placeholder('Link optional login account'),
                                    ]),
                                Textarea::make('address')
                                    ->rows(3),
                            ]),

                        Section::make('Profile Photo')
                            ->columnSpan(1)
                            ->schema([
                                FileUpload::make('photo')
                                    ->image()
                                    ->directory('drivers')
                                    ->placeholder('Upload driver photo'),
                            ]),

                        Section::make('Licensing & Experience')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('license_number')
                                            ->maxLength(255)
                                            ->label('Driver License Number (SIM)')
                                            ->placeholder('e.g. SIM-123456789'),
                                        DatePicker::make('license_expired_at')
                                            ->label('SIM Expiration Date'),
                                        TextInput::make('identity_number')
                                            ->maxLength(255)
                                            ->label('Identity Number (KTP)')
                                            ->placeholder('e.g. 3273012345670001'),
                                        TextInput::make('experience_years')
                                            ->numeric()
                                            ->default(0)
                                            ->label('Driving Experience (Years)')
                                            ->placeholder('e.g. 5'),
                                    ]),
                            ]),

                        Section::make('Status & Contact')
                            ->columnSpan(1)
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'available' => 'Available',
                                        'on_trip' => 'On Trip',
                                        'off_duty' => 'Off Duty',
                                        'inactive' => 'Inactive',
                                        'suspended' => 'Suspended',
                                    ])
                                    ->default('available')
                                    ->required(),
                                TextInput::make('emergency_contact')
                                    ->maxLength(255)
                                    ->placeholder('e.g. 0812-xxxx (Istri)'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->circular()
                    ->defaultImageUrl('/images/driver-placeholder.png'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('license_number')
                    ->label('SIM')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('experience_years')
                    ->label('Exp (Yrs)')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'on_trip' => 'amber',
                        'off_duty' => 'gray',
                        'inactive' => 'danger',
                        'suspended' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('license_expired_at')
                    ->label('SIM Expired')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'on_trip' => 'On Trip',
                        'off_duty' => 'Off Duty',
                    ]),
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
