<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name'];

    /*
     * one unit is needed for many shoppingitems
     */
    public function shoppingitems():HasMany{
        return $this->hasMany(Shoppingitem::class);
    }
}
