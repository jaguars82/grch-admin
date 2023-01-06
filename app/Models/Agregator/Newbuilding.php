<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newbuilding extends Model
{
    use HasFactory;

    protected $connection = 'mysql_grch';

    protected $table = 'newbuilding';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['newbuilding_complex_id', 'name', 'longitude', 'latitude', 'azimuth', 'detail', 'total_floor', 'material', 'status', 'deadline', 'created_at', 'updated_at', 'region_id', 'city_id', 'district_id', 'street_type_id', 'street_name', 'building_number', 'building_type_id', 'feed_name', 'active'];


    public function newbuildingComplex()
    {
        return $this->belongsTo(NewbuildingComplex::class, 'newbuilding_complex_id');
    }

}
