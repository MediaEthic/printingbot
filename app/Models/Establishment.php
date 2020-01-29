<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'establishments';


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
        'company_id',
        'name',
        'logo',
        'address_line1',
        'address_line2',
        'address_line3',
        'zipcode',
        'city',
        'country_id',
        'language_id',
        'time_zone_id',
        'phone',
        'email',
        'head_quotation',
        'foot_quotation',
        'head_delivery',
        'foot_delivery',
        'head_invoice',
        'foot_invoice',
        'invoice_prefix1',
        'invoice_prefix2',
        'active',
    ];


    /**
     * Get the company of the establishment.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the country of the establishment.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the language of the establishment.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the timezone of the establishment.
     */
    public function timezone()
    {
        return $this->belongsTo(TimeZone::class);
    }


    /**
     * Get all of the users for the establishment.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all of the lines for the establishment.
     */
    public function lines() {
        return $this->hasMany(InvoiceLine::class);
    }
}
