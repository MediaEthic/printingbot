<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contacts';


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
        'third_id',
        'title',
        'name',
        'lastname',
        'profession',
        'service',
        'email',
        'mobile',
        'phone',
        'default',
        'active',
    ];


    /**
     * Get the third of the contact.
     */
    public function third()
    {
        return $this->belongsTo(Third::class);
    }
}
