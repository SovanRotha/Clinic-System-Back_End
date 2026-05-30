<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorModel extends Model
{
    use HasFactory;

    protected $table = 'doctor';

    protected $fillable = [
        'user_id',
        'doctor_code', 
        'working_day', 
        'start_time', 
        'end_time',
        "status"
    ];

    public function user(){
        return $this->belongsTo(RegisterModel::class, 'user_id');
    }
}
