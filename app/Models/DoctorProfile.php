<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    use HasFactory;
    protected $fillable=['picture','specialization','experience_years','experience'];
    public function profile()
    {
        return $this->morphOne(User::class, 'profileable');
    }
}
