<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wakif extends Model
{

    protected $fillable = ['name'];

    public function wakafLands()
    {
        return $this->hasMany(WakafLand::class, 'wakif_id');
    }
}
