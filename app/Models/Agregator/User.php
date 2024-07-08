<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $connection = 'mysql_grch';

    protected $table = 'user';

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
