<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'name',
        'description',
        'qty',
        'price',
        'total',
    ];


    /**
     * Get the invoice of the product.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
