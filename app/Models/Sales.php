<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'saleses';
    protected $guarded = ['id'];

    public function estimates()
    {
        return $this->hasMany(Estimate::class, 'sales_id');
    }
}
