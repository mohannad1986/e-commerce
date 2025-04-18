<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // هاد مدل وير ال رول تع ال  API
    // هاد المدل وير بيعتمد انه يعمل 3 ادوار مختلفة ولكل دور راوتمحدد يعني مفي تسلسل بالوصول
    public function handle(Request $request, Closure $next, $role)
    {
        // $user = JWTAuth::parseToken()->authenticate();

        // if (!$user || !$user->hasRole($role)) {
        //     return response()->json(['error' => 'Unauthorized - Insufficient role'], 403);
        // }

        // return $next($request);
   

    // +++++++++++++++++++++++++++++++++++++++++++++
    // هذا الكود يسمح للسوبر ادمن بالدخول الى ي دور اقل منه 
    // public function handle(Request $request, Closure $next, $role)
    // {
    //     $user = $request->user();

    //     // التحقق من أن المستخدم مسجل دخول
    //     if (!$user) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     // إذا كان المستخدم Super Admin، أعطه كل الصلاحيات
    //     if ($user->hasRole('super-admin')) {
    //         return $next($request);
    //     }

    //     // إذا لم يكن Super Admin، تحقق مما إذا كان لديه الدور المطلوب
    //     if (!$user->hasRole($role)) {
    //         return response()->json(['error' => 'Unauthorized'], 403);
    //     }

    //     return $next($request);
    // }
    // +++++++++++++++++++++++++++++++++++++++++++++

    // التعديل النهائي 

    // هذا عدلناه مشان مايتطبق على ال  blade 
    // يعني يكون فقط لل api 
    // +++++++++++++++++++++++++++++
     // إذا كان المستخدم داخل من session (يعني من Blade)
     if (Auth::check()) {
        // تجاوز هذا الميدل وير بالكامل
        return $next($request);
    }

    // محاولة الحصول على المستخدم من JWT
    try {
        $user = JWTAuth::parseToken()->authenticate();
    } catch (\Exception $e) {
        return response()->json(['error' => 'Unauthorized - Invalid or missing token'], 401);
    }

    // إذا كان Super Admin، اسمح له بالمرور لأي دور
    if ($user->hasRole('super-admin')) {
        return $next($request);
    }

    // إذا لم يكن لديه الدور المطلوب
    if (!$user->hasRole($role)) {
        return response()->json(['error' => 'Unauthorized - Insufficient role'], 403);
    }

    return $next($request);
}
    // ++++++++++++++++++++++++++

}


