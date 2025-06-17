<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    const MALE_ID = 1;
    const FEMALE_ID = 2;
    const ADDICTED_ID = 1;
    const NEUROTIC_ID = 2;

    const NEW_ADICTED_ID = 501;
    const NEW_NEUROTIC_ID = 502;

    public function category()
    {
        return $this->belongsTo(\App\Models\ClientCategory::class);
    }
    public function sex()
    {
        return $this->belongsTo(\App\Models\Sex::class);
    }

    public function getClientCodeAttribute()
    {
        return 'SNP-' . $this->code . mb_substr($this->sex->name, 0,1) . '-' . $this->pair_id . '-' . mb_substr($this->category->name, 0,1);
    }

    public function description()
    {
        return $this->hasOne(\App\Models\ClientDescription::class)->withDefault();
    }

    public function municipality()
    {
        return $this->belongsTo(\App\Models\Address\Municipality::class);
    }

    public function getMunOrpAttribute(): string
    {
        return isset($this->municipality) ? $this->municipality->name . ' (orp. ' . $this->municipality->orp->name . ')' : '';
    }

    public static function getNextPairId()
    {
        $lastClient = \App\Models\Client::where('pair_id', '!=', 'ZAJ')->orderByDesc('pair_id')->first();
        return $lastClient->pair_id + 1;
    }

    public function records(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Record::class, 'record_clients');
    }

    public function getLastRecordDateAttribute(): ?string
    {
        $lastRecord = $this->records->sortByDesc('date')->first();
        return $lastRecord ? Carbon::parse($lastRecord->date) : null;
    }

    public function getLastRecordDateFormatedAttribute(): string
    {
        $lastRecord = $this->last_record_date;
        return $lastRecord ? Carbon::parse($lastRecord)->format('j. n. Y') : '';
    }

    public function getHasValidContractAttribute(): bool
    {
        $records = $this->records->where('date', '>', Carbon::now()->subMonth(6));
        return $records->count() && $this->contract;
    }

    public function getContractDateAttribute(): string
    {
        return isset($this->contract) ? Carbon::parse($this->contract)->format('j. n. Y') : '';
    }

    public function getTypeAttribute(): string
    {
        return $this->pair_id === 'ZAJ' ? 'Zájemce' : 'Uživatel';
    }

    public function scopeWithValidContract(Builder $query)
    {
        return $query->whereNotNull('contract')->whereHas('records', function($query){
            $query->where('date', '>', Carbon::now()->subMonth(6));
        });
    }

    public function scopeOrderedByLastRecord(Builder $query)
    {
        return $query->orderByDesc('record.date');
    }
}
