<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'url', 'title'
    ];

    /*
     * a message belongs to one user
     */
    public function shoppinglist():BelongsTo{
        return $this->BelongsTo(Shoppinglist::class);
    }
}
