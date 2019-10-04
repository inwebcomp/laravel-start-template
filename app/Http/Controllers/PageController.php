<?php

namespace App\Http\Controllers;

use App\Breadcrumbs;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function show($page)
    {
        $page = Page::findBySlug($page)->firstOrFail();

        return view('pages.page', [
            'page'        => $page,
            'breadcrumbs' => Breadcrumbs::page($page),
            'pageTitle'   => $page->title,
            'meta'        => array_merge([
                'title'       => $page->title,
            ], optional($page->metadata)->toArray() ?? []),
        ]);
    }
}
