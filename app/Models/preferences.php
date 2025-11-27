<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class preferences extends Model
{
       protected $fillable = [
        'name','image','color'
        
        
      
    ];

    public function users()
{
    return $this->belongsToMany(user::class);
}

}