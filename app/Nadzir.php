<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nadzir extends Model
{


    protected $fillable = ['name'];

    public function wakafLands()
    {
        return $this->hasMany(WakafLand::class, 'nadzir_id');
    }
}
