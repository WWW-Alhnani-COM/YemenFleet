<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'driver_name',
        'email',
        'address',
        'phone',
        'password',
        'company_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // العلاقات الأساسية
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'driver_id');
    }

    public function trucks()
    {
        return $this->belongsToMany(Truck::class, 'driver_truck', 'driver_id', 'truck_id')
                    ->withTimestamps();
    }

    // علاقة Polymorphic مع الإشعارات
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    // الوظائف المذكورة في الكلاس دايجرام
    public function login($email, $password)
    {
        return auth()->guard('driver')->attempt([
            'email' => $email,
            'password' => $password
        ]);
    }

    public function viewAssignedTasks()
    {
        return $this->tasks()->with('destination')->get();
    }

    public function updateStatus($status)
    {
        $this->update(['status' => $status]);
        return $this;
    }

    public function receiveNotification(Notification $notification)
    {
        return $this->notifications()->create([
            'message' => $notification->message,
            'is_read' => false,
            'is_group_message' => $notification->is_group_message,
            'sender_id' => $notification->sender_id,
            'sender_type' => $notification->sender_type,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}