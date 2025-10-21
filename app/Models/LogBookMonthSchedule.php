<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBookMonthSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['log_book_id', 'month_value'];

    public function logBook(): BelongsTo {
        return $this->belongsTo(LogBook::class);
    }
}
