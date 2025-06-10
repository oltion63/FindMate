<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements OAuthenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'image',
        'name',
        'lastname',
        'email',
        'city_id',
        'address',
        'password',
        'birthday',
        'phone',
        'gender',
        'role',
        'google_id',
        'email_verified_at',
        'is_premium',
    ];

    public function jobs(){
        return $this->hasMany(Post::class, 'user_id');
    }
    public function company(){
        return $this->hasOne(Company::class, 'user_id');
    }
    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }
    public function applications(){
        return $this->hasMany(Application::class, 'user_id');
    }
    public function cv(){
        return $this->hasOne(Cv::class, 'user_id');
    }
    public function savedPosts(){
        return $this->hasMany(Post::class, 'user_id');
    }


    public function isPremium(): bool
    {
        return (bool) $this->is_premium;
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
