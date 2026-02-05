<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabelPlace extends Model
{
    protected $fillable = ['label_id', 'place_id'];


    public function label()
    {
        return $this->belongsTo(preference::class);
    }
    public function place()
    {
        return $this->belongsTo(TuristicPlace::class, 'place_id');
    }
}
