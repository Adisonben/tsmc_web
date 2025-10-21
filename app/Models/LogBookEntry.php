<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBookEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_book_id',
        'ma_item_id',
        'schedule_column',
        'date',
        'mileage',
        'action_check',
        'action_adjust',
        'action_replace',
    ];

    public function logBook() {
        return $this->belongsTo(LogBook::class);
    }

    public function maItem() {
        return $this->belongsTo(MaItem::class);
    }
}
