<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Instructor extends Model
{
    use HasFactory;

    public function User()
    {
       return $this->hasOne(User::class);
    }

    public function Lesson()
    {
        return $this->belongsToMany(Lesson::class);
    }
}
