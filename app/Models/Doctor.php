<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $guarded = [];

    protected $table = 'doctors';
    protected $primaryKey = 'doctor_id';
    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';
}
