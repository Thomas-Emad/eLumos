<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;


class StatisticCourseService
{

  public function avargetWatchs($enrolls): array
  {
    $groupedResults = $enrolls->select(DB::raw('count(*) as count'), 'progress_lectures as progress')->groupBy('progress_lectures')->get('count');
    $counts = [];
    $progress = [];

    // Split With right format for Charts
    foreach ($groupedResults as $result) {
      $counts[] = $result->count;
      $progress[] = $result->progress;
    }

    return [
      'counts' => $counts,
      'progress' => $progress,
      'enrolleds_count' => sizeof($groupedResults)
    ];
  }

  public function profits($orders)
  {
    $earns = 0;
    $result = [];
    foreach ($orders as $order) {
      $earns += $order->profit;
      $result[] = [
        'x' => $order->date,
        'y' => $order->profit
      ];
    }
    return [
      'charts' => $result,
      'earns' => $earns
    ];
  }
}
