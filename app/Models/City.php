<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'city_id' );
    }
    public function posts(){
        return $this->hasMany(Post::class, 'location_id');
    }
}
