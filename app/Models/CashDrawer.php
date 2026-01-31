<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class CashDrawer extends Model
{
    use HasFactory;

    protected $fillable = [
        'cashier_id',
        'drawer_number',
        'opening_balance',
        'expected_cash',
        'actual_cash',
        'difference',
        'status',
        'opened_at',
        'closed_at',
        'notes',
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'expected_cash'   => 'decimal:2',
        'actual_cash'     => 'decimal:2',
        'difference'      => 'decimal:2',
        'opened_at'       => 'datetime',
        'closed_at'       => 'datetime',
    ];

    /* =====================
     |  RELATIONSHIPS
     ===================== */

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function logs()
    {
        return $this->hasMany(CashDrawerLog::class);
    }

    /* =====================
     |  ACCESSORS (UNTUK BLADE)
     ===================== */

    public function getOpenedAtDateAttribute()
    {
        return $this->opened_at
            ? $this->opened_at->timezone('Asia/Jakarta')->format('d M Y')
            : null;
    }

    public function getOpenedAtTimeAttribute()
    {
        return $this->opened_at
            ? $this->opened_at->timezone('Asia/Jakarta')->format('H:i')
            : null;
    }

    public function getClosedAtDateAttribute()
    {
        return $this->closed_at
            ? $this->closed_at->timezone('Asia/Jakarta')->format('d M Y')
            : null;
    }

    public function getClosedAtTimeAttribute()
    {
        return $this->closed_at
            ? $this->closed_at->timezone('Asia/Jakarta')->format('H:i')
            : null;
    }

    /* =====================
     |  HELPERS
     ===================== */

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }
}
