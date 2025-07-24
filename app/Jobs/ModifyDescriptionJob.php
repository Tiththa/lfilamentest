<?php

namespace App\Jobs;

use App\Models\Product;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;


class ModifyDescriptionJob implements ShouldQueue
{
    use Queueable;

    public $product;
    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($product_id, $data)
    {
        $this->product = Product::find($product_id);
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // modify the product description with custom addition
        $this->product->description = $this->product->description . ' ' . $this->data['custom_addition'];
        $this->product->save();

        Notification::make()
            ->title('Description modified successfully')
            ->success()
            ->sendToDatabase(auth()->user());

    }
}
