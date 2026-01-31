<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';

    protected $fillable = [
        'po_number',
        'outlet',
        'supplier',
        'status',
        'total_amount',
        'note',
        'created_by',
        'expected_delivery',
        'fulfilled_at',
    ];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
