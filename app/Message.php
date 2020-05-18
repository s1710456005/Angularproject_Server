<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'shoppinglist_id','user_id', 'messagetext', 'created_at'
    ];

    /*
     * a message belongs to one user
     */
    public function user():BelongsTo{
        return $this->BelongsTo(User::class);
    }

    /*
 * a message belongs to one user
 */
    public function shoppinglist():BelongsTo{
        return $this->BelongsTo(Shoppinglist::class);
    }
}
