<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    protected $fillable = [
        'websetting_id',
        'day_name',
        'day_index',
        'from_time',
        'to_time',
    ];

    public function websetting()
    {
        return $this->belongsTo(Websetting::class);
    }
}
