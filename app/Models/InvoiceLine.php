<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invoice_lines';


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
        'invoice_id',
        'establishment_id',
        'type',
        'name',
        'description',
        'order_line_id',
        'delivery_line_id',
        'product_id',
        'vat_id',
        'quantity',
        'unit_price',
        'subtotal',
        'discount_rate',
        'discount_amount',
        'total_pretax',
        'vat',
        'total',
    ];


    /**
     * Get the invoice of the invoice line.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the establishment of the invoice line.
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the country of the invoice line.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the vat of the invoice line.
     */
    public function vat()
    {
        return $this->belongsTo(Vat::class);
    }
}
