<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'name',
        'address',
        'latitude',
        'longitude',
        'phone_number',
        'user_id'
    ];

    /**
     * Returns a list of cars that are on the location
     *
     * @return HasMany
     */
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    /**
     * Returns the user that the location belongs to
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
