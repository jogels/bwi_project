<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Photo;

class WakafLand extends Model
{
    protected $table = 'wakaf_lands'; // Sesuaikan dengan nama tabel yang Anda gunakan
    protected $fillable = [
        'regis_no',
        'city_id',
        'subdistrict_id',
        'village_id',
        'area_size',
        'used',
        'object_name',
        'address',
        'status',
        'certificate_no',
        'certificate_date',
        'aiw_no',
        'aiw_date',
        'latitude',
        'longitude',
        'wakif_name',
        'nadzir_name',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict_id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'wakaf_land_photos', 'wakaf_land_id', 'photo_id');
    }
}
