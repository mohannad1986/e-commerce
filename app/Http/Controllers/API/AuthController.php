<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    // تسجيل مستخدم جديد
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|exists:roles,name' // تأكد أن الدور موجود
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // إنشاء المستخدم
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // تعيين الدور للمستخدم
        $user->assignRole($request->role);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    // تسجيل الدخول
    public function login(Request $request)
    {  
        $credentials = $request->only(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    // استرجاع بيانات المستخدم
    public function profile()
    {
        $user = JWTAuth::parseToken()->authenticate();
        // return response()->json(['user' => $user], 200);
    //   هذا تعديل لجعله يرسل الصلاحيات والادوار و كل شيء في حال كنا نعمل ك فيو مثلا 
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(), // إرجاع جميع الأدوار
            'permissions' => $user->getAllPermissions()->pluck('name'), // إرجاع جميع الصلاحيات
        ], 200);
    }

    // تسجيل الخروج
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    // تحديث التوكن
    public function refreshToken()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    // تنسيق استجابة التوكن
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
