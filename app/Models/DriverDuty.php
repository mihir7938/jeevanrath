<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverDuty extends Model
{
    use HasFactory;

    protected $table = 'driver_duty';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'driver_id',
        'booking_id',
        'start_kilometre',
        'start_date',
        'start_time',
        'end_kilometre',
        'end_date',
        'end_time',
        'image',
    ];
    public function drivers() {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
}