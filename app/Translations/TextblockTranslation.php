<?php

namespace App\Translations;

use Illuminate\Database\Eloquent\Model;

class TextblockTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'text',
    ];
}
