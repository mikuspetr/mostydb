<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sex extends Model
{
    public $timestamps = false;

    const MALE = 1;
    const FEMALE = 2;
}
