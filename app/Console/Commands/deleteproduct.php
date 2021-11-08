<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class deleteproduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        $products = Product::get();
        foreach ($products as $products) {
            $this->info("{$products->name} =>id {$products->id}");
        }
        $id = $this->ask('The id of the product you need delete: ');
        $result = Product::find($id);
        if($result){
            $result->delete();
            $this->info('Product Deleted Successfuly');
            return Command::SUCCESS;
        }
        $this->info('Product not found!');
        return Command::SUCCESS;
    }
}
