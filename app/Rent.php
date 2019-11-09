<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'starting_location',
        'ending_location',
        'car_id',
        'user_id'
    ];

    /**
     * Returns the starting location of the rent
     *
     * @return HasOne
     */
    public function startingLocation()
    {
        return $this->hasOne(Location::class);
    }

    /**
     * Returns the ending location of the rent
     *
     * @return HasOne
     */
    public function endingLocation()
    {
        return $this->hasOne(Location::class);
    }

    /**
     * Returns the car that is rented
     *
     * @return HasOne
     */
    public function car()
    {
        return $this->hasOne(Car::class);
    }

    /**
     * Returns the user (customer) that rented the car
     *
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(User::class);
    }
}
