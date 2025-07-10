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
        'package_category_id',
        'package_category_name',
        'package_id',
        'package_name',
        'quantity',
        'rate',
        'amount',
        'remarks',
    ];
    public function packages() {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}