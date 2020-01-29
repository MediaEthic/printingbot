<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settlements';


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
        'name',
        'payment_within',
        'payment_on',
        'active',
    ];


    /**
     * Get all of the thirds for the settlement.
     */
    public function thirds() {
        return $this->hasMany(Third::class);
    }

    /**
     * Get all of the invoices for the settlement.
     */
    public function invoices() {
        return $this->hasMany(Invoice::class);
    }
}
