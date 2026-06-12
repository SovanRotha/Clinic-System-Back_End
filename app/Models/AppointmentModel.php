<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentModel extends Model
{
    use HasFactory;

    protected $table = 'appointment';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(DoctorModel::class, 'doctor_id');
    }

    public function consultation()
    {
        return $this->hasOne(ConsultationModel::class);
    }
    public function user()
    {
        return $this->belongsTo(RegisterModel::class, 'patient_id', 'id');
    }
    public function bill()
    {
        return $this->hasOne(BillModel::class);
    }
    
}
