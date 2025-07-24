<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTypeResource\Pages;
use App\Filament\Resources\ProductTypeResource\RelationManagers;
use App\Models\ProductType;
use App\Services\APIService;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class ProductTypeResource extends Resource
{
    protected static ?string $model = ProductType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('api_unique_number')->reactive(),
                Forms\Components\Select::make('address')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->dehydrated(false)
                    ->getSearchResultsUsing(function(string $query):array {
                        return collect(app(APIService::class)->autocompleteResultsDirectNBN($query))->mapWithKeys(function ($item) {
                            return [
                                $item['id'] => $item['formattedAddress'],
                            ];
                        })->toArray();
                    })->suffixAction(
                        Action::make('populateResults')
                            ->icon('heroicon-o-arrow-down-on-square-stack')
                            ->color('primary')
                            ->action(function (Forms\Get $get, Forms\Set $set) {
                                $state = $get('address');
                                if (blank($state)) {
                                    return;
                                }

                                $data = [];
                                $data['DirectoryIdentifier'] = $state;
                                $set('api_unique_number', $state);

                                $result = app(APIService::class)->nbnQualificationResults($data);
                                if ($result !== 'error') {
                                    $set('status_availability', $result);
                                }
                            })->visible(fn($state) => $state !== null && $state !== '')
                    ),
                Select::make('status_availability')
                    ->reactive()
                    ->options([
                        'available' => 'Available',
                        'not available' => 'Not Available',
                        'pending' => 'Pending',
                    ])->dehydrated(false)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('api_unique_number')
                    ->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ManageProductTypes::route('/'),
        ];
    }
}
