<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(RegisterModel::class, 'user_id');
    }

    public function appointments()
    {
        return $this->hasMany(AppointmentModel::class, 'doctor_id');
    }

    public function consultation()
    {
        return $this->hasMany(ConsultationModel::class, 'doctor_id');
    }

    public function prescription()
    {
        return $this->hasMany(PrescriptionModel::class);
    }

    
}
