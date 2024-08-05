<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonCategory extends Model
{
    use HasFactory;

    protected $connection = 'mysql_grch';

    protected $table = 'lesson_category';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['parent_category_id', 'sort_order', 'title', 'subtitle', 'description', 'image', 'icon', 'created_at', 'updated_at'];

}
