<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $primaryKey = 'sensor_id';

    protected $fillable = [
        'name',
        'type',
        'company_id'
    ];

    protected $casts = [
        'name' => 'string' // يمكن استخدام enum هنا
    ];

    // العلاقات
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function sensorData()
    {
        return $this->hasMany(SensorData::class, 'sensor_id');
    }

    // الوظائف
    public function sendData($value)
    {
        return $this->sensorData()->create([
            'value' => $value,
            'timestamp' => now()
        ]);
    }

    public function fetchData()
    {
        return $this->sensorData()
            ->orderBy('timestamp', 'desc')
            ->get();
    }
}
