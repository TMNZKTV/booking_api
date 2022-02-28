<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedReservation extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'date'
    ];
    protected $fillable = ['name', 'phone', 'conflict', 'visit_type', 'amount', 'note',
    'prepayment', 'table_id', 'place_id', 'date', 'time', 'responsible_email', 'responsible_name'];

    public function table() {
        return $this->belongsTo(Table::class);
    }
    public function place() {
        return $this->belongsTo(Place::class);
    }
}
