<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Third extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'thirds';


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
        'updated_by',
        'type',
        'name',
        'alias',
        'logo',
        'category_id',
        'order_confirmation',
        'bank_id',
        'parent_id',
        'customer',
        'address_line1',
        'address_line2',
        'address_line3',
        'postcode',
        'city',
        'country_id',
        'language_id',
        'time_zone_id',
        'email',
        'phone',
        'ape',
        'siret',
        'intracommunity_no',
        'territory_id',
        'user_id',
        'commission_rate',
        'discount_rate',
        'bank_rate',
        'discount_duration',
        'payment_id',
        'settlement_id',
        'vat_id',
        'holder',
        'bank',
        'bank_code',
        'sort_code',
        'account',
        'rib',
        'iban',
        'bic',
        'subledger_account',
        'concentration_account',
        'invoice_number',
        'invoice_copy',
        'monthend_invoices',
        'grouping_invoices',
        'statement',
        'credit_control',
        'credit_limit',
        'credit_insurance',
        'allow_order',
        'head_order',
        'foot_order',
        'head_delivery',
        'foot_delivery',
        'head_invoice',
        'foot_invoice',
        'technical_remarks',
        'accounting_remarks',
        'mention_id',
        'active',
    ];


    /**
     * Get the user of the third.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    /**
     * Get the country of the third.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the language of the third.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the timezone of the third.
     */
    public function timezone()
    {
        return $this->belongsTo(TimeZone::class);
    }

    /**
     * Get the salesperson of the third.
     */
    public function salesperson()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Get the payment of the third.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the settlement of the third.
     */
    public function settlement()
    {
        return $this->belongsTo(Settlement::class);
    }

    /**
     * Get the vat of the third.
     */
    public function vat()
    {
        return $this->belongsTo(Vat::class);
    }


    /**
     * Get all of the addresses for the third.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get all of the contacts for the third.
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get all of the invoices for the third.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
