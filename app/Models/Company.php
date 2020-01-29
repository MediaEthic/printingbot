<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';


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
        'logo',
        'legal_form',
        'capital',
        'register',
        'siret',
        'tva',
        'expiry_date',
    ];

    /**
     * Get all of the establishments for the company.
     */
    public function establishments()
    {
        return $this->hasMany(Establishment::class);
    }
}
