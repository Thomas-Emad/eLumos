<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
  use HasFactory, HasUuids;

  protected $fillable = ['publisher_id', 'title'];


  public function questions(): HasMany
  {
    return $this->hasMany(ExamQuestion::class, 'exam_id', 'id');
  }
}
