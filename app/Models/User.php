<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use SoftDeletes, HasRoles, HasFactory;

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function divisis(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }
}
