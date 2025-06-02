<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Prompts\Prompt;

class AdminCreate extends Controller
{
    public function AdminCreate(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        $adminListFilePath = storage_path('app/public/admins/admin_list.json');
        if (!file_exists($adminListFilePath)) {
            file_put_contents($adminListFilePath, json_encode([]));
        }
        $adminList = json_decode(file_get_contents($adminListFilePath), true);
        if (in_array($request->email, $adminList)) {
            return redirect()->back()->withErrors(['email' => 'Email is already used by another admin.'])->withInput();
        }

        if (strlen($request->password) < 5) {
            return redirect()->back()->withErrors(['password' => 'Password must be at least 8 characters.']);
        }
        elseif ($request->password !== $request->password_confirmation) {
            return redirect()->back()->withErrors(['password_confirmation' => 'Password confirmation does not match.']);
        }
        else
        {
        $adminFilePath = storage_path('app/public/admins/admin_' . uniqid() . '.json');
        $adminData = [
            'user_id' => uniqid(), // Generate a unique user ID
            'username' => $request->username, 
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password
            'created_at' => now(),
            'updated_at' => now(),
        ];
        file_put_contents($adminFilePath, json_encode($adminData, JSON_PRETTY_PRINT));
        $adminList[] = $request->email;
        file_put_contents($adminListFilePath, json_encode($adminList, JSON_PRETTY_PRINT));

        file_put_contents(base_path('.env'), str_replace(
            'APP_SETUP=false',
            'APP_SETUP=true',
            file_get_contents(base_path('.env'))
        ));

        }
        return redirect('/AdminSecurity')->with([
            'success' => 'Admin user created successfully. Email: ' . $request->email,
            'admin_id' => $adminData['user_id'],
            'username' => $request->username,
            'email' => $request->email
        ]);
    }
}
