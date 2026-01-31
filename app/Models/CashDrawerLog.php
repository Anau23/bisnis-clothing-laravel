<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashDrawerLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_drawer_id',
        'user_id',
        'transaction_type',
        'amount',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /* =====================
     |  RELATIONSHIPS
     ===================== */

    public function cashDrawer()
    {
        return $this->belongsTo(CashDrawer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* =====================
     |  ACCESSORS (UNTUK BLADE)
     ===================== */

    public function getCreatedAtDateAttribute()
    {
        return $this->created_at
            ? $this->created_at->timezone('Asia/Jakarta')->format('d M Y')
            : null;
    }

    public function getCreatedAtTimeAttribute()
    {
        return $this->created_at
            ? $this->created_at->timezone('Asia/Jakarta')->format('H:i')
            : null;
    }

    /* =====================
     |  HELPERS
     ===================== */

    public function isPositive(): bool
    {
        return $this->amount > 0;
    }
}
