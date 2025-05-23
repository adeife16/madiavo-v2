<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Get all settings
    public function index(Request $request)
    {
        $module = $request->query('module');

        $query = Setting::query();
        if ($module) {
            $query->where('module', $module);
        }

        return response()->json([
            'success' => true,
            'settings' => $query->get()->mapWithKeys(function ($setting) {
                return [$setting->key => $this->castValue($setting)];
            }),
        ]);
    }

    // Bulk update settings
    public function update(Request $request)
    {
        $data = $request->all();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value) : $value]
            );
        }

        return response()->json(['success' => true, 'message' => 'Settings updated successfully']);
    }

    // Optional: get single setting
    public function show($key)
    {
        $setting = Setting::where('key', $key)->first();

        return $setting
            ? response()->json(['success' => true, 'value' => $this->castValue($setting)])
            : response()->json(['success' => false, 'message' => 'Setting not found'], 404);
    }

    // Cast value according to type (e.g. int, bool)
    protected function castValue($setting)
    {
        switch ($setting->type) {
            case 'boolean':
                return filter_var($setting->value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int)$setting->value;
            case 'json':
                return json_decode($setting->value, true);
            default:
                return $setting->value;
        }
    }
}
