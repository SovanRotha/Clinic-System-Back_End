<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';
    
    use HasFactory;
    protected $fillable = [
        'user_id',
        'patient_code',
        'gender',
        'date_of_birth',
        'address',
        'blood_group'
    ];
    public function user()
    {
        return $this->belongsTo(RegisterModel::class, 'user_id');
    }

    public function appointments()
    {
        return $this->hasMany(AppointmentModel::class, 'patient_id');
    }

    public function bill(){
        return $this->hasMany(BillModel::class);
    }

    public function consultation()
    {
        return $this->hasMany(ConsultationModel::class, 'patient_id');
    }

    public function prescription()
    {
        return $this->hasMany(PrescriptionModel::class);    
    }

}
