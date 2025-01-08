<?php

namespace App\Enums;

enum StatusTicketEnum: string
{
  case PENDING = 'pending';
  case WAIT_SUPPORT = 'wait_support';
  case WAIT_USER = 'wait_user';
  case CLOSE_SUPPORT = 'close_support';
  case CLOSE_USER = 'close_user';
  case SOLVED = 'solved';

  public function label(): string
  {
    return match ($this) {
      static::PENDING => 'Pending',
      static::WAIT_SUPPORT => 'Wait Support',
      static::WAIT_USER => 'Wait User',
      static::CLOSE_SUPPORT => 'Closed By Support',
      static::CLOSE_USER => 'Closed By User',
      static::SOLVED => 'Solved',
    };
  }

  public function color(): string
  {
    return match ($this) {
      static::PENDING => 'text-amber-700',
      static::WAIT_SUPPORT => 'text-gray-700',
      static::WAIT_USER => 'text-gray-700',
      static::CLOSE_SUPPORT => 'text-red-700',
      static::CLOSE_USER => 'text-red-700',
      static::SOLVED => 'text-green-700',
    };
  }

  public function bgColor(): string
  {
    return match ($this) {
      static::PENDING => 'bg-amber-700',
      static::WAIT_SUPPORT => 'bg-gray-700',
      static::WAIT_USER => 'bg-gray-700',
      static::CLOSE_SUPPORT => 'bg-red-700',
      static::CLOSE_USER => 'bg-red-700',
      static::SOLVED => 'bg-green-700',
    };
  }
}
