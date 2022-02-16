<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Profile;
use App\Models\Post;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot(){

        parent::boot(); // Creates some sort of __construct for the profile of the user
        
        static::created(function ($user) {
            $user->profile()->create([
                'title' => $user->username,
            ]);
        } );
    }

    //One to one
    public function profile(){
        return $this->hasOne(Profile::class);
    }

    //One to many
    public function posts(){
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    //Many to Many
    public function following(){
        return $this->belongsToMany(Profile::class);
    }

}