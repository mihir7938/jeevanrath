<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Type;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'vehicles';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type_id',
    ];
    public function types() {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
}