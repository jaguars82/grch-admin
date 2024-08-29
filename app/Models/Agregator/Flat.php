<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    use HasFactory;

    const STATUS_SALE = 0;
    const STATUS_RESERVED = 1;
    const STATUS_SOLD = 2;

    protected $connection = 'mysql_grch';

    protected $table = 'flat';
}
