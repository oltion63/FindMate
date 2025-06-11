<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $fillable = [
        'user_id',
        'post_id',
        'description',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function post(){
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function admin(){
        return $this->belongsTo(User::class, 'reviewed_by');
    }


}
