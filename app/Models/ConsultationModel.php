<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationModel extends Model
{
    use HasFactory;

    protected $table = 'consultation';

    protected $fillable = [
        'appointment_id',
        'register_id',
        'patient_id',
        'doctor_id',
        'symptoms',
        'diagnosis',
        'note',
    ];

    public function appointment()
    {
        return $this->belongsTo(AppointmentModel::class, 'appointment_id');
    }

    public function user()
    {
        return $this->belongsTo(RegisterModel::class, 'register_id', 'id');
    }
    
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(DoctorModel::class, 'doctor_id');
    }

    public function prescription()
    {
        return $this->hasMany(PrescriptionModel::class);
    }
    public function bill()
    {
        return $this->hasOne(BillModel::class, 'patient_id', 'patient_id');
    }
    
}
