<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\SensorData;
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    public function index(Request $request)
    {
        $query = SensorData::with('sensor');

        if ($request->filled('sensor_id')) {
            $query->where('sensor_id', $request->sensor_id);
        }

        if ($request->filled('weather_type')) {
            $query->where('weather_type', $request->weather_type);
        }

        if ($request->filled('is_alerted')) {
            $query->where('is_alerted', $request->is_alerted);
        }

        $sensorData = $query->latest()->paginate(10);
        $sensors = Sensor::all();

        return view('admin.sensor_data.index', compact('sensorData', 'sensors'));
    }

    public function create()
    {
        $sensors = Sensor::all();
        return view('admin.sensor_data.create', compact('sensors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'timestamp' => 'required|date',
            'value' => 'required|json',
            'location' => 'nullable|string',
            'weather_type' => 'nullable|string',
            'obd_code' => 'nullable|string',
            'heart_rate' => 'nullable|integer',
            'blood_pressure' => 'nullable|string',
            'is_alerted' => 'boolean'
        ]);

        $sensorData = SensorData::create($data);
        $sensorData->createAlertIfCritical();

        return redirect()->route('admin.sensor_data.index')->with('success', 'تمت إضافة البيانات بنجاح');
    }

    public function show(SensorData $sensorDatum)
    {
        return view('admin.sensor_data.show', compact('sensorDatum'));
    }

    public function edit(SensorData $sensorDatum)
    {
        $sensors = Sensor::all();
        return view('admin.sensor_data.edit', compact('sensorDatum', 'sensors'));
    }

    public function update(Request $request, SensorData $sensorData)
    {
        $data = $request->validate([
            'sensor_id' => 'required|exists:sensors,id',
            'timestamp' => 'required|date',
            'value' => 'required|json',
            'location' => 'nullable|string',
            'weather_type' => 'nullable|string',
            'obd_code' => 'nullable|string',
            'heart_rate' => 'nullable|integer',
            'blood_pressure' => 'nullable|string',
            'is_alerted' => 'boolean'
        ]);

        $sensorData->update($data);
        $sensorData->createAlertIfCritical();

        return redirect()->route('admin.sensor_data.index')->with('success', 'تم تحديث البيانات بنجاح');
    }

    public function destroy(SensorData $sensorDatum)
    {
        $sensorDatum->delete();
        return redirect()->route('admin.sensor_data.index')->with('success', 'تم حذف البيانات بنجاح');
    }
}
