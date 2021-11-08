<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class deletecategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Category';

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
        $categories = Category::get();
        foreach ($categories as $category) {
            $this->info("{$category->name} =>id {$category->id}");
        }
        $id = $this->ask('The id of the category you need delete: ');
        $result = Category::find($id);
        if($result){
            $result->delete();
            $this->info('Category Deleted Successfuly');
            return Command::SUCCESS;
        }
        $this->info('Category not found!');
        return Command::SUCCESS;
        
        
    }
}
