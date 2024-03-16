<?php

namespace App\Enums;


enum TicketTypeEnum: int
{

    case NORMAL = 0;
    case TRANSFER = 1;
    case COMPLAIN = 2;

    public function background(): string
    {
        return match ($this) {
            self::NORMAL => 'bg-green',
            self::TRANSFER => 'bg-primary',
            self::COMPLAIN => 'bg-danger'
        };
    }

    public function isNormal():bool{
        return $this === self::NORMAL;
    }
    public function isTransfer():bool{
        return $this === self::TRANSFER;
    }
    public function isComplain():bool{
        return $this === self::COMPLAIN;
    }
}
