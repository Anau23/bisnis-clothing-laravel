<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'stock',
        'size',
        'color',
        'image_url',
    ];

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
