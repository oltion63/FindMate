<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    public function jobs(){
        return $this->hasMany(Post::class, 'category_id');
    }
}
