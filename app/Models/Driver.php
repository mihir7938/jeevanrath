<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'address',
        'mobile_number',
        'alternative_number',
        'id_proof',
        'id_proof_document',
    ];
    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}