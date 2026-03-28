<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;


class Game extends Model
{
    protected $fillable = [
        'starts_at',
        'status',
        'host_user_id',
    ];

    public $timestamps = false;

    public function riddle(): HasOne
    {
        return $this->hasOne(Riddle::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function hostUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_user_id');
    }

    public static function latestFinished(): ?self
    {
        return self::where('status', 'finished')
            ->latest('ends_at')
            ->first();
    }

    /**
     * Проверяет, есть ли запланированная игра с ведущим
     */
    public static function existsScheduledGame(): bool
    {
        return self::query()
            ->where('status', 'scheduled')
            ->whereNotNull('host_user_id')
            ->exists();
    }
    public function isHost(): bool
    {
        $user = auth()->user();
        return $this->host_user_id === $user->id;
    }

    public static function isActive(): bool
    {
        return self::query()
            ->where('status', 'active')
            ->exists();
    }

    public function isFinished()
    {
        return $this->status === 'finished';
    }

    public static function current(): Game|null
    {
        return self::query()
            ->where('status', 'active')
            ->first();
    }

    protected function startsAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            $value
                ? Carbon::parse($value)
                ->setTimezone('Europe/Minsk')
                : null,

            set: fn($value) =>
            $value
                ? Carbon::parse($value, 'Europe/Minsk')
                ->setTimezone('UTC')  // вернет экземпляр Carbon
                : null,
        );
    }

    protected function endsAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            $value
                ? Carbon::parse($value)
                ->setTimezone('Europe/Minsk')
                : null,

            set: fn($value) =>
            $value
                ? Carbon::parse($value, 'Europe/Minsk')
                ->setTimezone('UTC')  // вернет экземпляр Carbon
                : null,
        );
    }

    protected function casts(): array
    {
        return [
            'status' => GameStatus::class,
        ];
    }
}
