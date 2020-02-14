<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'addresses';


    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'third_id',
        'address_line1',
        'address_line2',
        'address_line3',
        'postcode',
        'city',
        'country_id',
        'language_id',
        'time_zone_id',
        'order',
        'delivery',
        'invoicing',
        'default',
        'active',
    ];


    /**
     * Get the third of the address.
     */
    public function third()
    {
        return $this->belongsTo(Third::class);
    }
}
