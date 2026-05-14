<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebsiteSettingResource\Pages;
use App\Models\WebsiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class WebsiteSettingResource extends Resource
{
    protected static ?string $model = WebsiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('General Branding')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('site_name')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('site_tagline')
                                            ->maxLength(255),
                                    ]),
                                Textarea::make('site_description')
                                    ->rows(3),
                                Textarea::make('footer_text')
                                    ->rows(2),
                            ]),

                        Section::make('Logo & Icons')
                            ->columnSpan(1)
                            ->schema([
                                FileUpload::make('logo')
                                    ->image()
                                    ->directory('settings'),
                                FileUpload::make('favicon')
                                    ->image()
                                    ->directory('settings'),
                            ]),

                        Section::make('Contact Details')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('phone')
                                            ->maxLength(255),
                                        TextInput::make('whatsapp_number')
                                            ->maxLength(255),
                                        TextInput::make('email')
                                            ->email()
                                            ->maxLength(255),
                                    ]),
                                TextInput::make('business_hours')
                                    ->maxLength(255)
                                    ->placeholder('e.g. Senin - Minggu (24 Jam)'),
                                Textarea::make('address')
                                    ->rows(2),
                                Textarea::make('google_maps_embed')
                                    ->rows(3)
                                    ->placeholder('Paste Google Maps iframe HTML here'),
                            ]),

                        Section::make('Social Media Links')
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('instagram_url')
                                    ->url(),
                                TextInput::make('facebook_url')
                                    ->url(),
                                TextInput::make('tiktok_url')
                                    ->url(),
                            ]),

                        Section::make('Global SEO Settings')
                            ->columnSpan(3)
                            ->collapsed()
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->maxLength(255),
                                        TextInput::make('meta_keywords')
                                            ->maxLength(255)
                                            ->placeholder('Comma-separated keywords'),
                                        Textarea::make('meta_description')
                                            ->rows(2)
                                            ->columnSpan(2),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('site_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('whatsapp_number')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('business_hours'),
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
            'index' => Pages\ListWebsiteSettings::route('/'),
            'create' => Pages\CreateWebsiteSetting::route('/create'),
            'edit' => Pages\EditWebsiteSetting::route('/{record}/edit'),
        ];
    }
}
