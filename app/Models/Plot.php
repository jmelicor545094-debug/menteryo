<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plot extends Model
{
    protected $fillable = [
        'plot_number',
        'section',
        'price',
        'status',
    ];

    public function owners()
    {
        return $this->belongsToMany(Owner::class, 'plot_owner');
    }

    public function deceased()
    {
        return $this->hasOne(Deceased::class);
    }

    public function burials()
    {
        return $this->hasMany(Burial::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
