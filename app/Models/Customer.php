<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone',
        'email',
        'address',
        'destination_id'
    ];

    // العلاقات
    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function reviews()
    {
        return $this->hasMany(CustomerReview::class, 'customer_id');
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    // الدالة مكتملة الحقول كما في الكلاس دايجرام
    public function receiveNotification(Notification $notification)
    {
        $this->notifications()->create([
            'message' => $notification->message,
            'is_read' => false,
            'is_group_message' => $notification->is_group_message,
            'sender_id' => $notification->sender_id,
            'sender_type' => $notification->sender_type,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // إمكانية إضافة إرسال إشعار بالبريد الإلكتروني أو push notification هنا
    }
}
