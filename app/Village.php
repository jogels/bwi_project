<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    // Tentukan kolom yang bisa diisi (fillable) jika perlu:
    public $timestamps = false;

    protected $fillable = ['subdistrict_id', 'name'];


    public function wakafLands()
    {
        return $this->hasMany(WakafLand::class, 'village_id');
    }
}
