<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $casts = [
        'date' => 'date'
    ];
    protected $fillable = ['name', 'phone', 'prepayment', 'amount', 'date', 'time', 'note', 'place_id', 'table_id'];

    public function table() {
        return $this->belongsTo(Table::class);
    }
    public function place() {
        return $this->belongsTo(Place::class);
    }
}

