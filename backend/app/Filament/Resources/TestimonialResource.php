<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Customer Feedback')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('customer_name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('customer_position')
                                            ->placeholder('e.g. CEO / Entrepreneur / Tourist')
                                            ->maxLength(255),
                                        Select::make('rating')
                                            ->options([
                                                5 => '⭐⭐⭐⭐⭐ (5 Stars)',
                                                4 => '⭐⭐⭐⭐ (4 Stars)',
                                                3 => '⭐⭐⭐ (3 Stars)',
                                                2 => '⭐⭐ (2 Stars)',
                                                1 => '⭐ (1 Star)',
                                            ])
                                            ->default(5)
                                            ->required(),
                                        TextInput::make('service_type')
                                            ->placeholder('e.g. Airport Transfer / Tour')
                                            ->maxLength(255),
                                    ]),
                                Textarea::make('message')
                                    ->required()
                                    ->rows(4),
                            ]),

                        Section::make('Settings & Photo')
                            ->columnSpan(1)
                            ->schema([
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
                                FileUpload::make('photo')
                                    ->image()
                                    ->directory('testimonials')
                                    ->imageEditor()
                                    ->placeholder('Upload customer photo'),
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
                    ->defaultImageUrl(asset('assets/img/default-avatar.png')),
                TextColumn::make('customer_name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('customer_position')
                    ->searchable(),
                TextColumn::make('rating')
                    ->alignCenter()
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                    ->sortable(),
                TextColumn::make('service_type')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        5 => '5 Stars',
                        4 => '4 Stars',
                        3 => '3 Stars',
                        2 => '2 Stars',
                        1 => '1 Star',
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
