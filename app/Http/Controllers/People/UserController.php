<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = Auth::user()->staffMembers()->latest()->get();
        return view('Pages.People.List_Users', compact('users'));
    }

    public function create()
    {
        return view('Pages.People.Add_User');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', 'in:manager,cashier'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'admin_id' => Auth::id(),
            // Copy shop details from admin so their profile defaults are pre-configured
            'shop_name' => Auth::user()->shop_name,
            'shop_logo' => Auth::user()->shop_logo,
        ]);

        return redirect()->route('user.index')->with('success', 'Staff member created successfully!');
    }

    public function edit($id)
    {
        $user = Auth::user()->staffMembers()->findOrFail($id);
        return view('Pages.People.Edit_User', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user()->staffMembers()->findOrFail($id);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:manager,cashier'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:8'];
        }

        $data = $request->validate($rules);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return redirect()->route('user.index')->with('success', 'Staff member updated successfully!');
    }

    public function destroy($id)
    {
        $user = Auth::user()->staffMembers()->findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Staff member deleted successfully!');
    }
}
