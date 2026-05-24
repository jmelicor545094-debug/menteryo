<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deceased extends Model
{
    protected $table = 'deceased';

    protected $fillable = [
        'full_name',
        'birth_date',
        'death_date',
        'plot_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
    ];

    public function getAgeAttribute(): int
    {
        return $this->birth_date->diffInYears($this->death_date);
    }

    public function plot()
    {
        return $this->belongsTo(Plot::class);
    }

    public function burials()
    {
        return $this->hasMany(Burial::class);
    }
}
