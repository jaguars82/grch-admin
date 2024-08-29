<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrance extends Model
{
    use HasFactory;

    protected $connection = 'mysql_grch';

    protected $table = 'entrance';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['newbuilding_id', 'name', 'number', 'floors', 'material', 'status', 'deadline', 'azimuth', 'longitude', 'latitude', 'created_at', 'updated_at'];

    /**
     * Get entrance Name by its ID.
     *
     * @param int $id
     * @return string|null
     */
    public static function getNameById(int $id): ?string
    {
        $entrance = self::find($id);
        return $entrance ? $entrance->name : null;
    }

    /**
     * Related Newbuilding
     */
    public function newbuilding()
    {
        return $this->belongsTo(Newbuilding::class, 'newbuilding_id');
    }
}
