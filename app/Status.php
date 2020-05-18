<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    //TODO protexted fillable
    protected $fillable = ['name'];

    /*
     * one status of this table is needed for many shoppinglists
     */
    public function shoppinglists():HasMany{
        return $this->hasMany(Shoppinglist::class);
    }
}
