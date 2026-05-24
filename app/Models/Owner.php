<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = [
        'full_name',
        'contact_number',
        'address',
    ];

    public function plots()
    {
        return $this->belongsToMany(Plot::class, 'plot_owner');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
