<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong database.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * Các cột có thể được gán giá trị.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    
}
