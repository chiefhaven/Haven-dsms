<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
