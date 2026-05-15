<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('Pages.Settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();
        
        $data = $request->validate([
            'shop_name' => 'required|string|max:255',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255',
            'shop_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'admin_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('shop_logo')) {
            $data['shop_logo'] = $request->file('shop_logo')->store('settings', 'cloudinary');
        }

        if ($request->hasFile('admin_photo')) {
            $data['admin_photo'] = $request->file('admin_photo')->store('settings', 'cloudinary');
        }

        $setting->update($data);

        return back()->with('success', 'Settings updated successfully!');
    }
}
