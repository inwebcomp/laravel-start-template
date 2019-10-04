<?php

namespace App;

use App\Models\Page;

class Breadcrumbs
{
    public static function page(Page $page)
    {
        $path = [];

        $path[] = [
            'title' => $page->title,
            'link'  => $page->path()
        ];

        return $path;
    }
}
