<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    
    protected $fillable = ['nbr','floor','price','type','status','description','images'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
