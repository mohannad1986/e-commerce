<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    public function index()
    { 
        // return 'ass';
        $users = User::with('roles', 'permissions')->get();
        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        // التأكد من صلاحية الـ Admin
        // if (!auth()->user()->hasRole('admin')) {
        //     return redirect()->back()->with('error', 'Unauthorized action.');
        // }

        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:super-admin,admin,user'
        ]);

        // إنشاء المستخدم
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // إسناد الدور المحدد
        $user->assignRole($request->role);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('users.create')->with('success', 'User created successfully.');
    }
}
