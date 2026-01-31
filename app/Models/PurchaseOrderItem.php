<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $table = 'purchase_order_items';

    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'variant_id',
        'quantity',
        'unit_price',
        'total_price',
        'received_quantity',
    ];
}
