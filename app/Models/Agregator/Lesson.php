<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $connection = 'mysql_grch';

    protected $table = 'lesson';

    public $timestamps = true;

    const HOSTING_YOUTUBE = 1;
    const HOSTING_RUTUBE = 2;
    const HOSTING_VKVIDEO = 3;
    const HOSTING_LOCAL = 10;

    public static $videohosting = [
        self::HOSTING_YOUTUBE => 'YouTube',
        self::HOSTING_RUTUBE => 'RuTube',
        self::HOSTING_VKVIDEO => 'VK-Video',
        self::HOSTING_LOCAL => 'Локальный сервер',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['lesson_category_id', 'sort_order', 'image', 'icon', 'title', 'subtitle', 'description', 'content', 'videohosting_type', 'video_source', 'created_at', 'updated_at'];

    public static function validationRules()
    {
        return [
            'lesson_category_id' => 'integer',
            'sort_order' => 'integer|min:1',
            'image' => 'string',
            'icon' => 'string',
            'title' => 'required|string|max:255',
            'subtitle' => 'string|max:255',
            'description' => 'string',
            'content' => 'string',
            'videohosting_type' => 'integer|max:2',
            'video_source' => 'string|max:255',
            'created_at' => 'date',
            'updated_at' => 'date',
        ];
    }

    /**
     * Amount of lessons
     */
    public static function getCount()
    {
        return self::count();
    }
}
