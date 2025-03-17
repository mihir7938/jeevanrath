<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JRVehicle extends Model
{
    use HasFactory;

    protected $table = 'jrvehicles';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_name',
        'vehicle_name',
        'vehicle_number',
        'mobile_number',
        'alternative_number',
        'city_id',
    ];
    public function cities() {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}