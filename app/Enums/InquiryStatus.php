<?php

namespace App\Enums;

enum InquiryStatus: string
{
    case NEW = 'new';
    case REPLIED = 'replied';
    case CLOSED = 'closed';

    public function isOpen(): bool
    {
        return in_array($this, [
            self::NEW,
            self::REPLIED,
        ]);
    }
}
