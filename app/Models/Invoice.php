<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invoices';


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
        'establishment_id',
        'invoice_no',
        'updated_by',
        'name',
        'invoice_date',
        'due_date',
        'invoice_status',
        'third_id',
        'third_alias',
        'third_name',
        'third_address_line1',
        'third_address_line2',
        'third_address_line3',
        'third_zipcode',
        'third_city',
        'country_id',
        'language_id',
        'time_zone_id',
        'third_intracommunity_no',
        'third_reference',
        'user_id',
        'user_commission_base',
        'user_commission_rate',
        'user_commission_amount',
        'discount_rate',
        'bank_rate',
        'discount_duration',
        'payment_id',
        'settlement_id',
        'subtotal',
        'discount_amount',
        'total_pretax',
        'vat',
        'total',
        'sales_id',
    ];


    /**
     * Get the establishment of the invoice.
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the user of the invoice.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    /**
     * Get the third of the invoice.
     */
    public function third()
    {
        return $this->belongsTo(Third::class);
    }

    /**
     * Get the country of the invoice.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the language of the invoice.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the timezone of the invoice.
     */
    public function timezone()
    {
        return $this->belongsTo(TimeZone::class);
    }

    /**
     * Get the salesperson of the invoice.
     */
    public function salesperson()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Get the payment of the invoice.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the settlement of the invoice.
     */
    public function settlement()
    {
        return $this->belongsTo(Settlement::class);
    }


    /**
     * Get all of the lines for the invoice.
     */
    public function lines() {
        return $this->hasMany(InvoiceLine::class);
    }
}
