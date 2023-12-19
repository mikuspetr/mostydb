<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    public function form()
    {
        return $this->belongsTo(\App\Models\RecordForm::class);
    }

    public function type()
    {
        return $this->belongsTo(\App\Models\RecordType::class);
    }

    public function kind()
    {
        return $this->belongsTo(\App\Models\RecordKind::class);
    }

    public function place()
    {
        return $this->belongsTo(\App\Models\RecordPlace::class);
    }

    public function clients()
    {
        return $this->belongsToMany(\App\Models\Client::class, 'record_clients');
    }
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'record_users');
    }
}
