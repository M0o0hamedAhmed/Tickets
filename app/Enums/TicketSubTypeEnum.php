<?php

namespace App\Enums;


enum TicketSubTypeEnum: int
{

    case OPEN = 0;
    case WAITING = 1;
    case CLOSED = 2;

    public function background(): string
    {
        return match ($this) {
            self::OPEN => 'bg-green',
            self::WAITING => 'bg-primary',
            self::CLOSED => 'bg-danger'
        };
    }

    public function isOpen(): bool
    {
        return $this === self::OPEN;
    }

    public function isWaiting(): bool
    {
        return $this === self::WAITING;
    }

    public function isClosed(): bool
    {
        return $this === self::CLOSED;
    }

}
