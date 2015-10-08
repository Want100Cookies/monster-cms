<?php

/**
 * VIEW A LIST OF VIEW IN A SPECIFIC DIRECTORY:
 * http://laravel-tricks.com/tricks/show-all-available-views
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Page;

class PanelController extends Controller
{
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
        return view('panel.page.create', ['availableBlocks' => $this->getBlockList(), 'currentBlocks' => array()]);
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

        return view('panel.page.create', ['availableBlocks' => $this->getBlockList(), 'currentBlocks' => $page->blocks, 'page' => $page]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
