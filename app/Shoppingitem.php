<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shoppingitem extends Model
{
    //TODO protected
    protected $fillable = ['shoppinglist_id','unit_id', 'title', 'quantity', 'price'];

    /*
     * everyone creates its own shopping items,
     * they are always new and therefore unique in each shoppinglist.
     * Thus the shoppingitem belongs always to one shoppinglist
     */
    public function shoppinglist():BelongsTo{
        return $this->belongsTo(Shoppinglist::class);
    }

    /*
     * there are a set of units available which can be chosen for one shoppingitem
     * therefore the shoppingitem belongs to one unit of the product
     */
    public function unit():BelongsTo{
        return $this->belongsTo(Unit::class);
    }
}
