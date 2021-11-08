<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class addcategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $name = $this->ask('Category Name: ');

        $categories = Category::get();
        foreach ($categories as $category) {
            $this->info("{$category->name} =>id {$category->id}");
        }
        $parent_category = $this->ask('category parent id if exists!: ');

        // validation
        $validator = Validator::make([
            'name' => $name,
            'parent_category' => $parent_category,
        ], [
            'name' => ['required', 'min:5', 'max:12'],
            'parent_category' => ['required'],
        ]);

    
        if ($validator->fails()) {
            $this->info('Category not created. See error messages below:');
        
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $category = new Category();


        $category->name = $name;
        $category->category_id = $parent_category;
        $category->save();
        
        $this->info("Saved.");

        return Command::SUCCESS;
    }
}
