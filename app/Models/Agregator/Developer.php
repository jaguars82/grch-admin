<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    protected $connection = 'mysql_grch';

    protected $table = 'developer';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['contact_id', 'name', 'address', 'logo', 'detail', 'longitude', 'latitude', 'free_reservation', 'paid_reservation', 'import_id', 'offer_info', 'sort', 'edited_fields', 'phone', 'url', 'email'];

    public static function validationRules()
    {
        return [
            'contact_id' => 'nullable|integer',
            'name' => 'string|max:200',
            'address' => 'nullable|string|max:200',
            'logo' => 'nullable|string|max:200',
            'detail' => 'nullable|string',
            'longitude' => [
                'nullable',
                'numeric',
                'regex:/^\d{1,8}(\.\d{1,6})?$/',
            ],
            'latitude' => [
                'nullable',
                'numeric',
                'regex:/^\d{1,8}(\.\d{1,6})?$/',
            ],
            'free_reservation' => 'nullable|string',
            'paid_reservation' => 'nullable|string',
            'offer_info' => 'nullable|string',
            'sort' => 'nullable|integer',
            'edited_fields' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
        ];
    }

    public function newbuildingComplexes()
    {
        return $this->hasMany(NewbuildingComplex::class);
    }

    public function hasNewbuildingComplexes(): bool
    {
        return $this->newbuildingComplexes()->exists();
    }

    public function newbuildingComplexesWithActiveBuildings()
    {
        return $this->hasMany(NewbuildingComplex::class)->onlyActive()->onlyWithActiveBuildings();
    }

}
