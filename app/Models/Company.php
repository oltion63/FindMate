<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'image',
        'description',
        'address',
        'phone',
        'website',
        'email',
    ];

    public function jobs(){
        return $this->hasMany(Post::class, 'company_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
