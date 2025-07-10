<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'package_km',
        'package_hr',
        'rate',
        'ex_km_rate',
        'ex_hr_rate',
    ];
    public function categories() {
        return $this->belongsTo(PackageCategory::class, 'category_id', 'id');
    }
    public function assign_packages() {
        return $this->belongsTo(AssignPackage::class, 'id', 'package_id');
    }
}
