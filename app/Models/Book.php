<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // per utilizzare metodo CREATE in controller è necessario abilitare i campi scrivibili
    //(altrimenti utilizzare INSERT/SAVE nel controller che non richiede protezioni)
    protected $fillable = ['title', 'author', 'image'];

    public function users(){
        return $this->belongsToMany(User::class)
            ->withPivot(['order', 'quote', 'review', 'related'])  //extra attributo da specificare con withPivot
            ->withTimestamps();
    }

    public function recap(){
        //
    }
}
