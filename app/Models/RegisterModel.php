<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;


class RegisterModel extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'register';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role',
        'token'
    ];
<<<<<<< HEAD
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
    public function doctor(){
        return $this->hasOne(DoctorModel::class);
=======
    
    public function doctor(){
        return $this->hasOne(DoctorModel::class);
    }
    public function patient()
    {
        return $this->hasOne(Patient::class);
>>>>>>> 8249489e104d4d3c69b301e24ea4720350530c23
    }
}
