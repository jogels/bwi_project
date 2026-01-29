<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'path',
        'caption',
        'created_at'
    ];

    public function wakafLands()
    {
        return $this->belongsToMany(WakafLand::class, 'wakaf_land_photos', 'photo_id', 'wakaf_land_id');
    }
}
