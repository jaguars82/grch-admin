<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewbuildingComplex extends Model
{
    use HasFactory;

    protected $connection = 'mysql_grch';

    protected $table = 'newbuilding_complex';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['developer_id', 'longitude', 'latitude', 'logo', 'detail', 'offer_new_price_permit', 'project_declaration', 'algorithm', 'offer_info', 'created_at', 'updated_at', 'active', 'region_id', 'city_id', 'district_id', 'street_type_id', 'street_name', 'building_type_id', 'building_number', 'master_plan', 'archive_id', 'bank_tariffs', 'feed_name', 'has_active_buildings', 'use_virtual_structure', 'virtual_structure'];

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function newbuildings()
    {
        return $this->hasMany(Newbuilding::class);
    }

}
