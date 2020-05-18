<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Shoppinglist extends Model
{
    //TODO protected
    protected $fillable = ['user_id', 'volunteer_id', 'status_id','title', 'total_amount', 'deadline','updated_at'];


    /*
     * the shoppinglist has many shopping items (1:n)
     */
    public function shoppingitems():HasMany{
        return $this->hasMany(Shoppingitem::class);
    }

    /*
     * the the shoppinglist has many bills,
     * this is the case if for eg. the volunteer was in several shops
     */
    public function bills():HasMany{
        return $this->hasMany(Bill::class);
    }

    /*
     * the shoppinglist has many feedback-messages
     */
    public function messages():HasMany{
        return $this->hasMany(Message::class);
    }

    /*
     * the shoppinglist belongs to exact one Status
     */
    public function status():BelongsTo{
        return $this->belongsTo(Status::class);
    }

    /*
     * the shoppinglist belongs to one owner/user
     */
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    /*
     * the shoppinglist belongs to one volunteer
     */
    public function volunteer():BelongsTo{
        return $this->belongsTo(User::class);
    }




}
