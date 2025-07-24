<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageGrid extends Model
{
    protected $table = 'package_grid';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enquiry_id',
        'package_id',
        'charge_id',
        'flag',
        'rate',
        'amount',
        'remarks',
    ];
    public function packages() {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}