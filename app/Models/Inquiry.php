<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\InquiryStatus;

class Inquiry extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => InquiryStatus::class,
        ];
    }
}
