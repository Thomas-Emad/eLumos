<?php

namespace App\Actions;

use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class TopCategoiresUsedAction
{

  /**
   * getTopCategoires function
   * 
   * Get Top Categories Used By Instructors For his Courses
   *
   * @return Collection
   */
  public function getTopCategoires($limit): Collection
  {
    return Course::select('category_id', DB::raw('count(*) as count'))
      ->where('status', 'active')
      ->with('category:id,name,url')
      ->groupBy('category_id')
      ->orderBy("count", "desc")
      ->limit($limit)->get();
  }
}
