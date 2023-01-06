<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    protected $connection = 'mysql_grch';

    protected $table = 'developer';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['contact_id', 'name', 'address', 'logo', 'detail', 'longitude', 'latitude', 'free_reservation', 'paid_reservation', 'import_id', 'offer_info', 'sort', 'edited_fields', 'phone', 'url', 'email'];

    public function newbuildingComplexes()
    {
        return $this->hasMany(NewbuildingComplex::class);
    }

}
