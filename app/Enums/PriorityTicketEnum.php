<?php

namespace App\Enums;

enum PriorityTicketEnum: string
{
  case LOW = 'low';
  case MEDIUM = 'medium';
  case HIGH = 'high';

  public function label(): string
  {
    return match ($this) {
      static::LOW => 'Low',
      static::MEDIUM => 'Medium',
      static::HIGH => 'High',
    };
  }
  public function color(): string
  {
    return match ($this) {
      static::LOW => 'text-gray-700',
      static::MEDIUM => 'text-amber-700',
      static::HIGH => 'text-red-700',
    };
  }
  public function bgColor(): string
  {
    return match ($this) {
      static::LOW => 'bg-gray-700',
      static::MEDIUM => 'bg-amber-700',
      static::HIGH => 'bg-red-700',
    };
  }
}
