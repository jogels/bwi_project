<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{

    // Tentukan kolom yang bisa diisi (fillable) jika perlu:
    protected $fillable = ['city_id', 'name'];

    public function wakafLands()
    {
        return $this->hasMany(WakafLand::class, 'subdistrict_id');
    }
}
