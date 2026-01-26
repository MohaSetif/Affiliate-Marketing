<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('merchant_id')
                                    ->relationship('merchant', 'company_name')
                                    ->required()
                                    ->searchable(),
                            ]),
                        RichEditor::make('description')
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->image()
                            ->directory('products'),
                    ]),
                Section::make('Commission Settings')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('commission_type')
                                    ->options([
                                        'fixed' => 'Fixed Amount (DZD)',
                                        'percent' => 'Percentage (%)',
                                    ])
                                    ->required(),
                                TextInput::make('commission_value')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0),
                                Toggle::make('is_active')
                                    ->label('Active for Promotion')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }
}
