<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignPackage extends Model
{
    use HasFactory;

    protected $table = 'assign_packages';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'package_id',
        'rate',
        'ex_km_rate',
        'ex_hr_rate',
    ];

    public function packages()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
