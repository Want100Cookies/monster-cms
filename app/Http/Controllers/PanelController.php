<?php

/**
 * VIEW A LIST OF VIEW IN A SPECIFIC DIRECTORY:
 * http://laravel-tricks.com/tricks/show-all-available-views
 */


namespace App\Http\Controllers;

use App\Block;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Page;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class PanelController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
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
            "name" => "required",
            "slug" => "required|unique:page",
            "enabled" => "required|accepted"
        ]);

        $input = $request->input();
        $input["user_id"] = $request->user()->id;

        Page::create($input);

        return redirect()->action("PanelController@edit", $input["slug"]);
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
            "content" => "required",
            "enabled" => "required|boolean",
            "page_id" => "required|exists:page,id",
            "slug" => "required|unique:block,slug,NULL,id,page_id," . $request->input("page_id"),
            "type" => "required"
        ]);

        $block = Block::create($request->input());

        return view("panel.page.blockEdit", ["block" => $block]);
    }

    /**
     * Get a single block's content
     *
     * @param   \Illuminate\Http\Request    $request
     * @return  \Illuminate\Http\Response
     */
    public function getBlock(Request $request)
    {
        $block = Block::findOrFail($request->input("blockId"));

        return $block;
    }

    /**
     * Update an block
     *
     * @param  \Illuminate\Http\Request     $request
     * @return  \Illuminate\Http\Response
     */
    public function updateBlock(Request $request)
    {
        $this->validate($request, [
            "id" => "required|exists:block,id",
            "content" => "required",
            "slug" => "required|unique:block,slug," . $request->input("id") . ",id,page_id," . $request->input("page_id"),
            "enabled" => "required|boolean",
            "class" => "required"
        ]);

        $input = $request->input();

        $input["content"] = json_encode($input["content"]);
        unset($input["id"]);
        unset($input["_token"]);
        unset($input["page_id"]);

        $block = Block::where('id', $request->input('id'))
            ->update($input);

        return view("panel.page.blockEdit", ["block" => Block::find($request->input("id"))]);
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
           "id" => "required|exists:block,id"
        ]);

        Block::destroy($request->input("id"));

        return "true";
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
     * Get a list with all available blocks
     *
     * @return Array strings
     */
    private function getBlockList() // TODO: make path variable in config file
    {
        $full_path = base_path('resources\views\blocks');

        if(!is_dir($full_path))
            return 'Blocks directory not found';

        $files = scandir($full_path);
        unset($files[0]);
        unset($files[1]);



        foreach($files as $key => $file)
        {
            if (strpos($file, 'edit') !== false)
            {
                unset($files[$key]);
            }
            else
            {
                $files[$key] = str_replace('.blade.php', '', $file);
            }
        }

        return $files;
    }

}
