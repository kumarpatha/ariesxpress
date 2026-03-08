<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'code',
        'address',
        'city',
        'state',
        'pincode',
        'phone',
        'email',
        'is_active',
    ];

    public function originConsignments()
    {
        return $this->hasMany(Consignment::class, 'origin_branch_id');
    }

    public function destinationConsignments()
    {
        return $this->hasMany(Consignment::class, 'destination_branch_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
