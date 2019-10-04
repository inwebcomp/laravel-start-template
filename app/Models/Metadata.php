<?php

namespace App\Models;

use InWeb\Base\Entity;
use InWeb\Base\Traits\BindedToModelAndObject;
use Dimsav\Translatable\Translatable;

/**
 * Class Metadata
 *
 * @package App
 * @property string title
 * @property string description
 */
class Metadata extends Entity
{
    use Translatable,
        BindedToModelAndObject;

    public $translationModel     = 'App\Translations\MetadataTranslation';
    public $translatedAttributes = ['title', 'description'];

    public function getTable()
    {
        return 'metadata';
    }

    public function toArray()
    {
        $data = [];

        if ($this->title)
            $data['title'] = $this->title;

        if ($this->description)
            $data['description'] = $this->description;

        return $data;
    }
}
