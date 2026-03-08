<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'mobile',
        'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($admin) {
            $admin->unique_id = (string) Str::uuid();
        });
    }

    public function consignments()
    {
        return $this->hasMany(Consignment::class, 'created_by');
    }

    public function statusLogs()
    {
        return $this->hasMany(ConsignmentStatusLog::class, 'updated_by');
    }
}
