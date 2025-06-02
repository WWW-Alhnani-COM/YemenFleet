<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $primaryKey = 'maintenance_id';

    protected $fillable = [
        'type',
        'cost',
        'date',
        'description',
        'truck_id',
        'invoice_id'
    ];

    protected $casts = [
        'date' => 'datetime',
        'cost' => 'decimal:2'
    ];

    // العلاقات
    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    // الوظائف
    public function logEntry()
    {
        $this->truck->update(['vehicle_status' => 'maintenance']);
        return $this->save();
    }

    public function generateInvoice()
    {
        $invoice = Invoice::create([
            'title' => "فاتورة صيانة #{$this->maintenance_id}",
            'amount' => $this->cost,
            'issued_date' => now(),
            'due_date' => now()->addDays(30),
            'maintenance_id' => $this->maintenance_id
        ]);
        
        $this->invoice()->associate($invoice);
        $this->save();
        
        return $invoice;
    }
}
