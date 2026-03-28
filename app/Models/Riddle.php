<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\RiddleStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

class Riddle extends Model
{
    use Searchable;

    protected $guarded = [
        'id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): HasOne
    {
        return $this->hasOne(Riddle::class);
    }

    public function shouldBeSearchable(): bool
    {
        return $this->isPublished();
    }

    // $this->status - объект/ сторогое сравнение с RiddleStatus::PUBLISHED->value всегда даст false
    public function isPublished(): bool
    {
        return $this->status === RiddleStatus::PUBLISHED;
    }

    /**
     * Определяем, какие поля индексировать в Meilisearch
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        return [
            'title'  => $this->title,   // заголовок загадки
            'riddle' => $this->riddle,  // текст загадки
            'searchable' => $this->searchable
        ];
    }

    public function searchableAs(): string
    {
        return 'riddles';
    }

    protected function casts(): array
    {
        return [
            'game_id' => 'integer',
            'status' => RiddleStatus::class,
        ];
    }
}
