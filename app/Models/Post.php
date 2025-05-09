<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Location;
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'company_id',
        'tittle',
        'description',
        'type',
        'salary',
        'nrWorkers',
        'location_id',
        'expiration_date',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function location(){
        return $this->belongsTo(City::class, 'location_id');
    }
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function applications(){
        return $this->hasMany(Application::class, 'post_id');
    }
    public function savedPosts(){
        return $this->hasMany(Post::class, 'post_id');
    }
}
