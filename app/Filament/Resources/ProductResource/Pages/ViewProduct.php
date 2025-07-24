<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Jobs\ModifyDescriptionJob;
use App\Models\Product;
use Filament\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\ViewEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected $listeners = ['refreshInfolist' => '$refresh'];

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ViewEntry::make('statusbar')
                    ->label('Status Bar')
                    ->view('filament.infolists.entries.status-bar'),
                TextEntry::make('name')
                    ->label('Product Name'),
                TextEntry::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->suffixAction(
                        Action::make('modifyDescription')
                            ->label('Modify Description')
                            ->icon('heroicon-o-pencil')
                            ->button()
                            ->action(function(Product $product) {
                                // Logic to modify the description
                                $data['custom_addition'] = '[This was added by the custom action via Job]';
                                ModifyDescriptionJob::dispatch($product->id, $data);
                                Notification::make()
                                    ->title('Job Dispatched successfully')
                                    ->success()
                                    ->send();
                            })
                    )->extraAttributes([
                        'wire:poll.2s' => '',
                    ]),
                TextEntry::make('category.name')
                    ->label('Category'),
                TextEntry::make('color.name')
                    ->label('Color'),
            ]);
    }
}

