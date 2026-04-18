<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    protected $fillable = [
        'consignment_note_number',
        'tracking_number',
        'booking_date',
        'consigner_name',
        'consigner_address',
        'consigner_gst_number',
        'consignee_name',
        'consignee_address',
        'consignee_gst_number',
        'phone_number',
        'item_description',
        'origin',
        'destination',
        'origin_branch_id',
        'destination_branch_id',
        'no_of_boxes',
        'actual_weight',
        'chargeable_weight',
        'service_mode',
        'total_amount',
        'grand_total',
        'final_remark',
        'delivery_status',
        'created_by',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($consignment) {
            $consignment->consignment_note_number = strtoupper(trim((string) $consignment->consignment_note_number));
            $consignment->tracking_number = $consignment->consignment_note_number;
        });

        static::creating(function ($consignment) {
            $consignment->delivery_status = 'booking';
        });
    }

    // Relationships
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function originBranch()
    {
        return $this->belongsTo(Branch::class, 'origin_branch_id');
    }

    public function destinationBranch()
    {
        return $this->belongsTo(Branch::class, 'destination_branch_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(ConsignmentStatusLog::class, 'consignment_id')
                    ->orderBy('created_at', 'desc');
    }

    public function latestStatusLog()
    {
        return $this->hasOne(ConsignmentStatusLog::class, 'consignment_id')
                    ->latestOfMany();
    }

    // Static helpers
    public static function getStatuses(): array
    {
        return [
            'booking'                => 'Booking',
            'dispatched'             => 'Dispatched',
            'in_transit'             => 'In Transit',
            'arrived_at_destination' => 'Arrived at Destination',
            'out_for_delivery'       => 'Out for Delivery',
            'delivered'              => 'Delivered',
            'pod_updated'            => 'POD Updated',
        ];
    }

    public static function getStatusBadgeClass(string $status): string
    {
        return match ($status) {
            'booking'                => 'secondary',
            'dispatched'             => 'info',
            'in_transit'             => 'primary',
            'arrived_at_destination' => 'warning',
            'out_for_delivery'       => 'orange',
            'delivered'              => 'success',
            'pod_updated'            => 'dark',
            default                  => 'light',
        };
    }

    public static function getStatusIconClass(string $status): string
    {
        return match ($status) {
            'booking'                => 'fa-clipboard-check',
            'dispatched'             => 'fa-paper-plane',
            'in_transit'             => 'fa-truck',
            'arrived_at_destination' => 'fa-warehouse',
            'out_for_delivery'       => 'fa-motorcycle',
            'delivered'              => 'fa-check-circle',
            'pod_updated'            => 'fa-file-signature',
            default                  => 'fa-circle',
        };
    }

    public static function getServiceModes(): array
    {
        return [
            'road'    => 'Road',
            'air'     => 'Air',
            'rail'    => 'Rail',
            'express' => 'Express',
        ];
    }

    // Scopes
    public function scopeByStatus($query, string $status)
    {
        return $query->where('delivery_status', $status);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('consignment_note_number', 'like', "%{$term}%")
              ->orWhere('tracking_number', 'like', "%{$term}%")
              ->orWhere('consigner_name', 'like', "%{$term}%")
              ->orWhere('consignee_name', 'like', "%{$term}%")
              ->orWhere('phone_number', 'like', "%{$term}%");
        });
    }
}
