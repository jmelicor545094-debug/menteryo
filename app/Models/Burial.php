<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Burial extends Model
{
    use HasFactory;

    protected $fillable = [
        'deceased_id',
        'plot_id',
        'created_by',
        'burial_date',
        'notes',
    ];

    protected $casts = [
        'burial_date' => 'date',
    ];

    public function deceased()
    {
        return $this->belongsTo(Deceased::class);
    }

    public function plot()
    {
        return $this->belongsTo(Plot::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}