<?php

/**
 * VIEW A LIST OF VIEW IN A SPECIFIC DIRECTORY:
 * http://laravel-tricks.com/tricks/show-all-available-views.
 */

namespace App\Http\Controllers;

use Flash;
use App\Page;
use App\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.dashboard', ['pages' => Page::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.page.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('panel.page.edit', ['availableBlocks' => $this->getBlockList(), 'currentBlocks' => $page->blocks, 'page' => $page]);
    }

    /**
     * Store a newly created page in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:page',
            'enabled' => 'required|accepted',
        ]);

        $input = $request->input();
        $input['user_id'] = $request->user()->id;

        Page::create($input);

        return redirect()->action('PanelController@edit', $input['slug']);
    }

    public function createBlock($pageId, $blockType)
    {
        return view('panel.block.create', ['pageId' => $pageId, 'type' => $blockType]);
    }

    /**
     * Store a newly created block in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBlock(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'page_id' => 'required|exists:page,id',
            'slug' => 'required|unique:block,slug,NULL,id,page_id,'.$request->input('page_id'),
            'type' => 'required',
        ]);

        $input = $request->input();
        $input['enabled'] = 1;

        $block = Block::create($request->input());

        $page_slug = Page::findOrFail($request->input('page_id'))->pluck('slug');

        Flash::success('Block created!');

        return redirect()->action('PanelController@edit', ['slug' => $page_slug]);
    }

    /**
     * Get a single block's content.
     *
     * @param   \Illuminate\Http\Request    $request
     * @return  \Illuminate\Http\Response
     */
    public function getBlock(Request $request)
    {
        $block = Block::findOrFail($request->input('blockId'));

        return $block;
    }

    public function editBlock($blockId)
    {
        $block = Block::findOrFail($blockId);

        return view('panel.block.edit', ['block' => $block]);
    }

    /**
     * Update an block.
     *
     * @param  \Illuminate\Http\Request     $request
     * @return  \Illuminate\Http\Response
     */
    public function updateBlock(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:block,id',
            'content' => 'required',
            'slug' => 'required|unique:block,slug,'.$request->input('id').',id,page_id,'.$request->input('page_id'),
            'enabled' => 'required|boolean',
        ]);

        $input = $request->input();

        unset($input['id']);
        unset($input['_token']);
        unset($input['page_id']);

        $block = Block::findOrFail($request->input('id'));

        $block->update($input);

        $page_slug = Page::findOrFail($block->page_id)->pluck('slug');

        Flash::success('Block updated!');

        return redirect()->action('PanelController@edit', ['slug' => $page_slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   \Illuminate\Http\Request    $request
     * @return  \Illuminate\Http\Response
     */
    public function destroyBlock(Request $request)
    {
        $this->validate($request, [
           'id' => 'required|exists:block,id',
        ]);

        Block::destroy($request->input('id'));

        return 'true';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //Todo: JS to send form and process data here
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Todo: Delete page code
    }

    /**
     * Get a list with all available blocks.
     *
     * @return array strings
     */
    private function getBlockList() // TODO: make path variable in config file
    {
        $full_path = base_path('resources\views\blocks');

        if (! is_dir($full_path)) {
            return 'Blocks directory not found';
        }

        $files = scandir($full_path);
        unset($files[0]);
        unset($files[1]);

        foreach ($files as $key => $file) {
            if (strpos($file, 'edit') !== false) {
                unset($files[$key]);
            } else {
                $files[$key] = str_replace('.blade.php', '', $file);
            }
        }

        return $files;
    }
}
