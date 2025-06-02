<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'company_id';
    
    protected $fillable = [
        'company_name',
        'phone_company',
        'email_company',
        'address_company',
        'owner_name',
        'phone_owner',
        'password',
        'economic_activity',
        'commercial_reg_number',
        'fleet_type',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // جميع العلاقات السبعة المذكورة في المخطط:
    public function products() {
        return $this->hasMany(Product::class, 'company_id');
    }

    public function drivers() {
        return $this->hasMany(Driver::class, 'company_id');
    }

    public function trucks() {
        return $this->hasMany(Truck::class, 'company_id');
    }

    public function subscriptions() {
        return $this->hasMany(Subscription::class, 'company_id');
    }

    public function sensors() {
        return $this->hasMany(Sensor::class, 'company_id');
    }

    public function companyOrders() {
        return $this->hasMany(CompanyOrder::class, 'company_id');
    }

    public function notifications() {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
