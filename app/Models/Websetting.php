<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Websetting extends Model
{
    public function openingHours()
    {
        return $this->hasMany(OpeningHour::class)->orderBy('day_index');
    }
}
