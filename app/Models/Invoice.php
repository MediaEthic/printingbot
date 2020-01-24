<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_no',
        'invoice_date',
        'due_date',
        'title',
        'client',
        'client_address',
        'sub_total',
        'discount',
        'total',
        'status',
    ];


    /**
     * Get all of the products for the invoice.
     */
    public function lines() {
        return $this->hasMany(InvoiceProduct::class);
    }
}
