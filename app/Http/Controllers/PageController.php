<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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
