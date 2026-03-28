<?php

namespace App\Enums;

enum GameStatus: string
{
    case SCHEDULED = 'scheduled';
    case ACTIVE = 'active';
    case FINISHED = 'finished';

    public function label(): string
    {
         return match ($this) {
            self::SCHEDULED => 'Запланирована',
            self::ACTIVE => 'Активна',
            self::FINISHED => 'Завершена',
        };
    } 
    
    
    public function canTransitionTo(self $newStatus): bool
    {
        return match ($this) {
            self::SCHEDULED => $newStatus === self::ACTIVE,
            self::ACTIVE => $newStatus === self::FINISHED,
            self::FINISHED => false,
        };
    }
}