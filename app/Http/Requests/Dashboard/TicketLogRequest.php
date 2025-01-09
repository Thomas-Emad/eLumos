<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use Illuminate\Validation\Rule;


class TicketLogRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    $ticket = Ticket::findOrFail($this->ticket_id);
    if ($ticket->user_id == Auth::id() || Auth::user()->hasPermissionTo('support')) {
      return true;
    } else {
      return  abort(403);
    }
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'ticket_id' => "required|exists:tickets,id",
      'reason' => [Rule::requiredIf(request()->routeIs('dashboard.tickets.changeStatus')), 'min:20', "max:1000"],
      'priority' => [Rule::requiredIf(request()->routeIs('dashboard.tickets.changePriority')), "in:low,medium,high"],
      'status' => [Rule::requiredIf(request()->routeIs('dashboard.tickets.changeStatus')), 'in:solved,close_user,close_support']
    ];
  }

  /**
   * Handle a failed validation attempt.
   *
   * @param  \Illuminate\Contracts\Validation\Validator  $validator
   * @return void
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  protected function failedValidation(Validator $validator)
  {
    // Redirect back with session data and validation errors
    redirect()->back()->with([
      'notification' => [
        'type' => 'fail',
        'message' => 'Something is wrong: ' . $validator->errors()->first(),
      ],
    ])->withErrors($validator)->throwResponse();
  }
}
