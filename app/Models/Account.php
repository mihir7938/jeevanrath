<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'companies';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'acc_id',
        'mobile_number',
    ];

    public function company_assign_packages()
    {
        return $this->hasMany(AssignPackage::class, 'company_id', 'id');
    }
}