<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBookKmSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['log_book_id', 'km_value'];

    public function logBook(): BelongsTo {
        return $this->belongsTo(LogBook::class);
    }
}
