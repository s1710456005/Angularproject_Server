<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'volunteer', 'firstname','lastname','address','zip','city', 'ctry', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * one user writes many messages
     * the relation is needed to be able to view the creator of the message
     * in the shoppinglist
     */
    public function messages():HasMany{
        return $this->hasMany(Message::class);
    }

    /**
     * as a person seeking help, it has many shoppinglists
     */
    public function shoppinglists():HasMany{
        return $this->HasMany(Shoppinglist::class);
    }


    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this ->getKey();
    }

    /**
     * @return array
     * set specific and additional data in the jwt
     * used to get the id of the user as well as if he is a volunteer or searcher
     */
    public function getJWTCustomClaims()
    {
        return [ 'user' => [ 'id' => $this -> id,  'volunteer'=> $this->volunteer]];
    }
}
