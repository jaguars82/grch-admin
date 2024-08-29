<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class NewbuildingComplex extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;

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

    /**
     * List of flats (in newbuildings) with outdated updates
     */
    public function flatsWithOutdatedUpdates()
    {
        $outdatePeriod = Carbon::now()->subHours(2);

        return $this->hasManyThrough(
            Flat::class,
            Newbuilding::class,
            'newbuilding_complex_id',
            'newbuilding_id',
            'id',
            'id'
        )
        ->where('newbuilding.active', '=', 1)
        ->where('flat.status', '=', Flat::STATUS_SALE)
        ->where('flat.updated_at', '<=', $outdatePeriod);
    }

    /**
     * Local scope to filter only active Newbuilding Comlexes
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyActive(Builder $query)
    {
        return $query->where('active', self::STATUS_ACTIVE);
    }

    /**
     * Local scope to filter only active Newbuilding Comlexes
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyWithActiveBuildings(Builder $query)
    {
        return $query->where('has_active_buildings', 1);
    }

}
