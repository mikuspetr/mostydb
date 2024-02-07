<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Record extends Model
{
    use HasFactory;

    public function form(): BelongsTo
    {
        return $this->belongsTo(\App\Models\RecordForm::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(\App\Models\RecordType::class);
    }

    public function kind(): BelongsTo
    {
        return $this->belongsTo(\App\Models\RecordKind::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(\App\Models\RecordPlace::class);
    }

    public function recordClients(): HasMany
    {
        return $this->hasMany(\App\Models\RecordClient::class);
    }

    public function recordUsers(): HasMany
    {
        return $this->hasMany(\App\Models\RecordUser::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Client::class, 'record_clients');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'record_users');
    }

    public function addClient(Client $client)
    {
        if($this->clients->where('id', $client->id)->count() == 0)
        {
            $recordClient = new RecordClient();
            $recordClient->record_id = $this->id;
            $recordClient->client_id = $client->id;
            $recordClient->save();
        }
    }

    public function addUser(User $user)
    {
        if($this->users->where('id', $user->id)->count() == 0)
        {
            $recordUser = new RecordUser();
            $recordUser->record_id = $this->id;
            $recordUser->user_id = $user->id;
            $recordUser->save();
        }
    }

    public function addUsers(Collection $users)
    {
        $record = $this;
        $usersArray = $users->map(function($user) {
            return [
                'record_id' => $this->id,
                'user_id' => $user->id
            ];
        })->filter(function($item)  use($record){
            return !$record->hasUserId($item['user_id']);
        })->toArray();
        RecordUser::insert($usersArray);
        $this->refresh();
    }

    public function addClients(Collection $clients)
    {
        $record = $this;
        $clientsArray = $clients->map(function($client) {
            return [
                'record_id' => $this->id,
                'client_id' => $client->id
            ];
        })->filter(function($item)  use($record){
            return !$record->hasClientId($item['client_id']);
        })->toArray();
        RecordClient::insert($clientsArray);
        $this->refresh();
    }

    public function hasUserId(int $id): bool
    {
        return $this->users->where('id', $id)->count() > 0;
    }
    public function hasClientId(int $id): bool
    {
        return $this->clients->where('id', $id)->count() > 0;
    }
}
