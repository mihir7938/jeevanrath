<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'vehicle_details';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'state_id',
        'city_id',
        'type_id',
        'vehicle_id',
        'rate',
        'taxi_doors',
        'passengers',
        'luggage_carry',
        'air_condition',
        'gps_navigation',
        'origin_trip',
        'return_trip',
        'vehicle1',
        'rate1',
        'vehicle2',
        'rate2',
        'vehicle3',
        'rate3',
        'vehicle4',
        'rate4',
        'vehicle5',
        'rate5',
        'vehicle_image',
    ];
    public function vehicles() {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
    public function types() {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
    public function states() {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
    public function cities() {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}