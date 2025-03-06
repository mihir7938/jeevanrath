<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiry extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'enquiry';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_type',
        'company_name',
        'name',
        'journey_date',
        'mobile_number',
        'email',
        'pickup_from',
        'drop_to',
        'vehicle_name',
        'journey_type',
        'status',
        'booking_id',
        'driver_id',
        'vehicle_number',
        'pickup_location',
        'pickup_time',
    ];
    public function drivers() {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
}