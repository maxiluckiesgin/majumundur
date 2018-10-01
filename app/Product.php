<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  const UPDATED_AT = NULL;
  const CREATED_AT = NULL;
  
  public function merchant()
    {
        return $this->belongsTo('App\User');
    }
}
