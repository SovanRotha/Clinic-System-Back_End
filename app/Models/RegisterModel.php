<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class RegisterModel extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'register';

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'phone_number',
        'role',
        'token',
    ];
    
    public function doctor(){
        return $this->hasOne(DoctorModel::class, 'user_id');
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id');
    }
    public function appointments()
    {
        return $this->hasMany(AppointmentModel::class, 'patient_id');
    }
}
