<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingUser extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'prepayment', 'amount', 'date', 'time', 'note', 'place_id', 'table'];
    public function table() {
        return $this->belongsTo(Table::class);
    }
    public function place() {
        return $this->belongsTo(Place::class);
    }
}
