<?php

namespace App\Models;

use App\Traits\WithMetadata;
use Dimsav\Translatable\Translatable;
use InWeb\Base\Contracts\HasPage;
use InWeb\Base\Entity;
use InWeb\Base\Support\Route;
use InWeb\Base\Traits\Positionable;
use InWeb\Base\Traits\TranslatableSlug;
use InWeb\Base\Traits\WithStatus;
use InWeb\Media\WithContentImages;
use Spatie\EloquentSortable\Sortable;

/**
 * Class Page
 *
 * @package App
 * @property string title
 * @property string slug
 * @property string description
 */
class Page extends Entity implements HasPage, Sortable
{
    use Translatable,
        WithContentImages,
        WithStatus,
        Positionable,
        TranslatableSlug,
        WithMetadata;

    public $translationModel = 'App\Translations\PageTranslation';
    public $translatedAttributes = ['title', 'slug', 'text'];

    protected $fillable = [
        'title',
        'slug',
        'text'
    ];

    public function path()
    {
        return Route::localized($this->slug);
    }
}
