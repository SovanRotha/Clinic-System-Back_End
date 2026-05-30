<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Register;

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
    public function register()
    {
        return $this->belongsTo(RegisterModel::class);
    }
}
