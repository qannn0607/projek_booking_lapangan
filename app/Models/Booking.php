<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    protected $fillable = ['field_id', 'customer_name', 'start_time', 'duration', 'total_price'];

    public function field() {
        return $this->belongsTo(Field::class);
    }
}
