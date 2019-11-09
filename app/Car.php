<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand',
        'model',
        'year',
        'fuel_type',
        'price',
        'available',
        'user_id',
        'location_id'
    ];

    /**
     * Returns the owner (user - business) of the car
     *
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the location where the car is
     *
     * @return BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Returns the rent where the car was rented
     *
     * @return BelongsTo
     */
    public function rents()
    {
        return $this->belongsTo(Rent::class);
    }
}
