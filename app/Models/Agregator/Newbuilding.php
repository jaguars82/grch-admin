<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newbuilding extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;

    protected $connection = 'mysql_grch';

    protected $table = 'newbuilding';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['newbuilding_complex_id', 'name', 'longitude', 'latitude', 'azimuth', 'detail', 'total_floor', 'material', 'status', 'deadline', 'created_at', 'updated_at', 'region_id', 'city_id', 'district_id', 'street_type_id', 'street_name', 'building_number', 'building_type_id', 'feed_name', 'active'];

    /**
     * Get newbuilding Name by its ID.
     *
     * @param int $id
     * @return string|null
     */
    public static function getNameById(int $id): ?string
    {
        $building = self::find($id);
        return $building ? $building->name : null;
    }

    /**
     * Related Newbuilding Complex
     */
    public function newbuildingComplex()
    {
        return $this->belongsTo(NewbuildingComplex::class, 'newbuilding_complex_id');
    }

    /**
     * Local scope to filter only active Buildings
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyActive(Builder $query)
    {
        return $query->where('active', self::STATUS_ACTIVE);
    }

}
