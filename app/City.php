<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $fillable = ['name'];

    public function wakafLands()
    {
        return $this->hasMany(WakafLand::class, 'city_id');
    }
}
