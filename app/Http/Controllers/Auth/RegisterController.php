<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * عرض صفحة التسجيل
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * معالجة طلب التسجيل
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'is_syrian' => ['required', 'boolean'],
            'current_country' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // إنشاء ملف شخصي للمستخدم
        Profile::create([
            'user_id' => $user->id,
            'is_syrian' => $request->is_syrian,
            'current_country' => $request->current_country,
        ]);

        // تعيين دور المستخدم العادي
        try {
            $user->assignRole('user');
        } catch (\Exception $e) {
            // إذا لم يكن الدور موجودًا، قم بإنشائه أولاً
            if (!Role::where('name', 'user')->exists()) {
                Role::create(['name' => 'user', 'guard_name' => 'web']);
                $user->assignRole('user');
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('social.feed'));
    }
} 