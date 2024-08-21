<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'headline',
        'description',
        'image',
        'preview_video',
        'language_id',
        'price',
        'learn',
        'requirements',
        'status',
        'level',
        'user_id',
    ];
}
