<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Advert extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function subscribers() : BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class);
    }
}
