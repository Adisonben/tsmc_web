<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaItem extends Model
{
    protected $fillable = ['cate_id', 'name'];

    public function getLogBookEntry() {
        return $this->hasMany(LogBookEntry::class, 'ma_item_id', 'id');
    }

    public function getLogBookEntryByLOgBookId($logbook_id, $column) {
        return $this->getLogBookEntry()->where('log_book_id', $logbook_id)->where('schedule_column', $column)->first();
    }
}
