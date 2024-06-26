<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;

    protected $connection = 'mysql_grch';

    protected $table = 'tariff';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['tariff_table', 'change', 'created_at', 'updated_at'];

}
