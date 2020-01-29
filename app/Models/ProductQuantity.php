<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductQuantity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_quantities';


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
        'product_id',
        'quantity_minimum',
        'quantity_maximum',
        'unit_price',
    ];


    /**
     * Get the product of the quantity.
     */
    public function product()
    {
        return $this->belongsTo(ProductQuantity::class);
    }
}
