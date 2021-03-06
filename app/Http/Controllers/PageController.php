<?php

namespace App\Http\Controllers;

use App\Page;

class PageController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug = 'homepage')
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('page', ['page' => $page, 'currentSlug' => $slug]);
    }
}
