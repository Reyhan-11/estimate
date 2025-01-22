<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estimate extends Model
{
    use SoftDeletes, HasRoles, HasFactory;

    protected $fillable = [
        'estimate_number',
        'estimate_date',
        'expiry_date',
        'customer_id',
        'sales_id',
    ];

    protected $dates = ['deleted_at'];

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'estimate_item')
            ->withPivot( 'quantity', 'rate', 'description')
            ->withTimestamps();
    }

    public function saleses()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $lastEstimate = self::latest('id')->first();
            $nextNumber = $lastEstimate ? (int) substr($lastEstimate->estimate_number, 4) + 1 : 1;
            $model->estimate_number = 'EST-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        });
    }
}
