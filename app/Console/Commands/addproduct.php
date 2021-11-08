<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class addproduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Product';

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
        $name = $this->ask('Product Name: ');
        $description = $this->ask('Product Description: ');
        $price = $this->ask('Product Price in DH: ');
        $image_url = $this->ask('Product image name after you store it under public/images: ');


        $categories = Category::get();
        foreach ($categories as $category) {
            $this->info("{$category->name} =>id {$category->id}");
        }
        $category = $this->ask('category id!: ');

        // validation
        $validator = Validator::make([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image_url' => $image_url,
            'category' => $category,
        ], [
            'name' => ['required', 'max:12'],
            'description' => ['required'],
            'price' => ['required'],
            'image_url' => ['required'],
            'category' => ['required'],
        ]);

        if ($validator->fails()) {
            $this->info('Product not created. See error messages below:');
        
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }



        $product = new Product();
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->image = $image_url;
        $product->category_id = $category;
        $product->save();
        
        $this->info("Saved.");

        return Command::SUCCESS;
    }
}
