<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function adverts() : BelongsToMany
    {
        return $this->belongsToMany(Advert::class);
    }
}
