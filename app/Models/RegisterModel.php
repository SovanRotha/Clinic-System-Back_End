<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
}
