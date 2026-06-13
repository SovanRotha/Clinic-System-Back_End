<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillModel extends Model
{
    use HasFactory;

    protected $table = 'bills';

    protected $fillable = [
        'patient_id',
        'register_id',
        'appointment_id',
        'consultation_fee',
        'medicine_fee',
        'total_amount',
        'payment_status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function appointment()
    {
        return $this->belongsTo(AppointmentModel::class, 'appointment_id');
    }
    public function user()
    {
        return $this->belongsTo(RegisterModel::class, 'register_id', 'id');
    }

}
