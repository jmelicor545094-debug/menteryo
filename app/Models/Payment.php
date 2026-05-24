<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'plot_id',
        'created_by',
        'amount',
        'payment_method',
        'payment_date',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
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