<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('Pages.Settings.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'shop_name' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'shop_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('shop_logo')) {
            $data['shop_logo'] = $request->file('shop_logo')->store('settings', 'cloudinary');
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('settings', 'cloudinary');
        }

        $user->update($data);

        return back()->with('success', 'Profile settings updated successfully!');
    }
}
