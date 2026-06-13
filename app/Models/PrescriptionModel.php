<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionModel extends Model
{
    use HasFactory;

    protected $table = 'prescription';

    protected $fillable = [
        'consultation_id',
        'register_id',
        'patient_id', 
        'doctor_id',
        'medicine_name',
        'dosage',
        'duration_time',
    ];

    public function consultation()
    {
        return $this->belongsTo(ConsultationModel::class, 'consultation_id');
    }

    public function doctor()
    {
        return $this->belongsTo(DoctorModel::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function user()
    {
        return $this->belongsTo(RegisterModel::class, 'register_id', 'id');
    }
    public function bill()
    {
        return $this->hasOne(BillModel::class, 'patient_id', 'patient_id');
    }
}
