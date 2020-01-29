<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vats';


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
        'rate',
        'collected',
        'deductible',
        'active',
    ];


    /**
     * Get all of the thirds for the vat.
     */
    public function thirds() {
        return $this->hasMany(Third::class);
    }

    /**
     * Get all of the lines for the vat.
     */
    public function lines() {
        return $this->hasMany(InvoiceLine::class);
    }
}
