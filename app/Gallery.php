<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'title',
        'description',
        'image',
        'style',
        'photo_position',
        'label',
        'sort_order',
        'status',
    ];
}
