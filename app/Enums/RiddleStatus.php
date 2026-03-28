<?php

namespace App\Enums;

enum RiddleStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
    case BLOCKED = 'blocked';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Черновик',
            self::PUBLISHED => 'Опубликованa',
            self::ARCHIVED => 'В архиве',
            self::BLOCKED => 'Заблокирована',
        };
    }
}
