<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

}
