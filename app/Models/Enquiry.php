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
        'end_journey_date',
        'total_days',
        'mobile_number',
        'email',
        'pickup_from',
        'drop_to',
        'vehicle_name',
        'vehicle',
        'journey_type',
        'booker_name',
        'booker_mobile',
        'status',
        'booking_id',
        'driver_id',
        'driver_name',
        'vendor_id',
        'vendor_name',
        'vehicle_number',
        'pickup_location',
        'pickup_time',
        'start_point_kilometer',
        'duty_on_kilometer',
        'duty_start_time',
        'end_point_kilometer',
        'duty_closed_kilometer',
        'duty_end_time',
        'end_duty_date',
        'image',
        'remarks',
        'fastag_amount',
        'fastag_image',
        'guest_name',
        'guest_number',
        'company_id',
        'db_name',
        'duty_closed',
        'duty_approved',
        'duty_approved_date',
        'total_kilometer',
        'extra_kilometer',
        'extra_time',
        'total_amount',
        'package_company_id',
        'package_company_name',
        'package_category_id',
        'package_category_name',
        'package_id',
        'package_name',
        'final_remarks',
    ];
    public function vendors() {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }
    public function drivers() {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
    public function companies() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function packages() {
        return $this->hasMany(PackageGrid::class, 'enquiry_id', 'id');
    }
}