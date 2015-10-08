<?php

use Illuminate\Database\Seeder;

use App\Page;
use App\Block;


class generateHomepage extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('page')->delete();
    	DB::table('block')->delete();

        $page = new Page;

        $page->name = 'Homepage';
        $page->slug = 'homepage';
        $page->enabled = true;
        $page->user_id = DB::table('users')->first()->id;

        $page->save();

        for ($i=0; $i < 12; $i++) { 
        	$block = new Block;

	        $block->slug = 'html_block' . $i;
	        $block->type = 'html';
	        $block->content = json_encode(array('html' => '<b>Bold ' . $i . ' block</b>'));
	        $block->class = 'col-md-1';
	        $block->enabled = true;
	        $block->page_id = $page->id;

	        $block->save();
        }

    }
}
