<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'total_price',
        'status',
        'order_date',
        'customer_id',
        'payment_id'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_price' => 'decimal:2'
    ];

    // العلاقات
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function destinations()
    {
        return $this->hasMany(Destination::class, 'order_id');
    }

    public function companyOrders()
    {
        return $this->hasMany(CompanyOrder::class, 'order_id');
    }

    // الوظائف
    public function calculateTotal()
    {
        $this->total_price = $this->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        $this->save();
        return $this->total_price;
    }

    public function addItem(Product $product, int $quantity)
    {
        return $this->items()->create([
            'product_id' => $product->product_id,
            'quantity' => $quantity,
            'price' => $product->getCurrentPrice()
        ]);
    }

    public function updateStatus(string $status)
    {
        $this->update(['status' => $status]);
        
        // تحديث حالة الدفع إذا كان مرتبطاً
        if ($this->payment) {
            $this->payment->update(['status' => $status]);
        }
        
        return $this;
    }
}
