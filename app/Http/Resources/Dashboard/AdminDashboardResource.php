<?php

namespace App\Http\Resources\Dashboard;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminDashboardResource extends JsonResource
{
  public int $totalReviews = 0;
  public int $totalOpenReviews = 0;
  public int $totalUsers = 0;
  public int $totalSales = 0;
  public int $totalProfit = 0;
  public int $totalUnwithdrawnProfit = 0;

  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $this->totalReviews = $this->whereNotNull("preview_at")->count();
    $this->totalOpenReviews = $this->whereNull("preview_at")->count();

    if (Auth::user()->hasPermissionTo('roles')) {
      $this->ownerStatistics();
    }

    return  [
      "totalReviews" => $this->totalReviews,
      "totalOpenReviews" => $this->totalOpenReviews,
      "totalUsers" => $this->totalUsers,
      "totalSales" => $this->totalSales,
      "totalProfit" => $this->totalProfit,
      "totalUnwithdrawnProfit" => $this->totalUnwithdrawnProfit,
    ];
  }

  /**
   * Get Statistics for the owner of the website.
   *
   * @return void
   */
  private function ownerStatistics(): void
  {
    $this->totalUsers = User::count();

    // get Orders Information
    $orders = Order::withSum('items', 'platform_profit')
      ->withSum(['items' => function ($query) {
        $query->where('withdraw', false);
      }], 'amount')
      ->where("status", "succeeded")->get(['id', 'status', 'amount']);

    $this->totalSales = $orders->sum('amount');
    $this->totalProfit =  $orders->sum("items_sum_platform_profit");
    $this->totalUnwithdrawnProfit =  $orders->sum("items_sum_amount");
  }
}
