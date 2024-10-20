<?php

namespace App\Http\Traits;

trait FilterByDateTrait
{
  /**
   * Returns an array of Carbon dates based on the given type of date.
   * Accepted types are:
   * - today
   * - yesterday
   * - last_week
   * - last_month
   * - this_year
   * - last_year
   *
   * If no type is given, or if the given type is not recognized, the function
   * will return an array of dates for the current year.
   *
   * @param string $type The type of date range to return.
   * @return array An array of two Carbon dates, the first being the start of the
   *               date range and the second being the end of the date range.
   */
  public static function filterByDate($type): array
  {
    return match ($type) {
      'today' => [now()->startOfDay(), now()->endOfDay()],
      'yesterday' => [now()->subDay()->startOfDay(), now()->endOfDay()],
      'last_week' => [now()->subDays(7)->startOfDay(), now()->endOfDay()],
      'last_month' => [now()->subMonth()->startOfMonth(), now()->endOfDay()],
      'this_year' => [now()->startOfYear(), now()->endOfDay()],
      'last_year' => [now()->subYear()->startOfYear(), now()->endOfDay()],
      default => [now()->startOfYear(), now()->endOfDay()],
    };
  }
}
