<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['title', 'applicant_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'room_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
