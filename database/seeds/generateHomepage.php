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

        $block = new Block;

        $block->slug = 'html_block';
        $block->type = 'html';
        $block->content = json_encode(array('content' => '<b>Bold html block</b>'));
        $block->class = 'col-md-2';
        $block->enabled = true;
        $block->page_id = $page->id;

        $block->save();
    }
}
