<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignmentStatusLog extends Model
{
    protected $fillable = [
        'consignment_id',
        'status',
        'comment',
        'location',
        'updated_by',
    ];

    public function consignment()
    {
        return $this->belongsTo(Consignment::class, 'consignment_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
