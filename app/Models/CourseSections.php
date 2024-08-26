<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseSections extends Model
{
  use HasFactory;

  protected $fillable = ['course_id', 'section_id', 'title', 'order_sort'];

  public function lectures(): HasMany
  {
    return $this->hasMany(CourseLectures::class, 'section_id', 'id');
  }
}
