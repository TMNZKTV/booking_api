<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restriction extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'date'
    ];

    protected $fillable = ['table_id', 'place_id', 'date', 'from', 'to'];

    public function table() {
        return $this->belongsTo(Table::class);
    }
    public function place() {
        return $this->belongsTo(Place::class);
    }
}
