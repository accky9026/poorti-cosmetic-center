<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'whatsapp_sent_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'whatsapp_sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'confirmed' => 'Confirmed',
            'packed' => 'Packed',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => 'Pending',
        };
    }

    public function nextStatus(): ?string
    {
        return match ($this->status) {
            'pending' => 'confirmed',
            'confirmed' => 'packed',
            'packed' => 'delivered',
            default => null,
        };
    }

    public function nextActionLabel(): ?string
    {
        return match ($this->status) {
            'pending' => 'Confirm Order',
            'confirmed' => 'Mark as Packed',
            'packed' => 'Mark as Delivered & Send Invoice',
            default => null,
        };
    }
}
