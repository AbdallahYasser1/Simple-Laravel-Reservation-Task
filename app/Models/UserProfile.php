<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable=['picture'];




    public function profile()
    {
        return $this->morphOne(User::class, 'profileable');
    }
}
