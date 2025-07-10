<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyEntry extends Model
{
    use HasFactory;

    protected $table = 'daily_entries';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enquiry_id',
        'booking_id',
        'journey_date',
        'starting_kilometer',
        'closing_kilometer',
        'difference',
        'in_time',
        'out_time',
        'ot_hrs',
        'remarks',
    ];
    public function enquiry() {
        return $this->belongsTo(Enquiry::class, 'enquiry_id', 'id');
    }
}