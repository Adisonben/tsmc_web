<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    protected $appends = ['maItems'];

    public function getMaItemsAttribute ()
    {
        return $this->hasMany(MaItem::class, 'cate_id', 'id')->get(['id', 'name', 'cate_id']);
    }
}
