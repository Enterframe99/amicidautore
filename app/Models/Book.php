<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function user(){
        return $this->belongsToMany(User::class)
            ->withPivot('order')
            ->withTimestamps();
    }
}
