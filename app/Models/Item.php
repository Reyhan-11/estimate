<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function estimates()
    {
        return $this->belongsToMany(Estimate::class, 'estimate_item')
                ->withPivot('description', 'quantity', 'rate')
                ->withTimestamps();
    }
}
