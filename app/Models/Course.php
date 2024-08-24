<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
  use HasFactory, SoftDeletes, HasUuids;

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


  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
}
