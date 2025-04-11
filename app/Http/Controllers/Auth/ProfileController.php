<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('profile.show', auth()->id());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::with([
                'profile', 
                'projects', 
                'volunteers.project', 
                'posts' => function($query) {
                    $query->with(['likes', 'comments', 'user.profile'])->latest()->limit(5);
                }
            ])->findOrFail($id);
            
            return view('profile.show', compact('user'));
        } catch (\Exception $e) {
            \Log::error('Error in profile show: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'حدث خطأ أثناء عرض الملف الشخصي');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        
        // التحقق من أن المستخدم يقوم بتعديل ملفه الشخصي الخاص به
        if(auth()->id() != $id) {
            return redirect()->route('profile.show', $id)->with('error', 'لا يمكنك تعديل ملف شخصي لا يخصك');
        }
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // التحقق من أن المستخدم يقوم بتعديل ملفه الشخصي الخاص به
            if(auth()->id() != $id) {
                return redirect()->route('profile.show', $id)->with('error', 'لا يمكنك تعديل ملف شخصي لا يخصك');
            }
            
            // التحقق من صحة البيانات
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$id,
                'phone' => 'nullable|string|max:20',
                'location' => 'nullable|string|max:255',
                'current_country' => 'nullable|string|max:255',
                'bio' => 'nullable|string',
                'skills' => 'nullable|string',
                'social_facebook' => 'nullable|url|max:255',
                'social_twitter' => 'nullable|url|max:255',
                'social_linkedin' => 'nullable|url|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            // تحديث بيانات المستخدم
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            
            // معالجة الصورة إذا تم تحميلها
            $avatarPath = null;
            if($request->hasFile('avatar')) {
                // تأكد من وجود مجلد التخزين
                if (!file_exists(storage_path('app/public/avatars'))) {
                    mkdir(storage_path('app/public/avatars'), 0777, true);
                }
                
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                
                // إذا كان لدى المستخدم صورة قديمة، قم بحذفها
                if($user->profile && $user->profile->avatar) {
                    try {
                        Storage::disk('public')->delete($user->profile->avatar);
                    } catch (\Exception $e) {
                        \Log::error('Error deleting old avatar: ' . $e->getMessage());
                    }
                }
            } else {
                $avatarPath = $user->profile && $user->profile->avatar ? $user->profile->avatar : null;
            }
            
            // تحديث أو إنشاء ملف تعريف للمستخدم
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => $request->phone,
                    'location' => $request->location,
                    'current_country' => $request->current_country,
                    'bio' => $request->bio,
                    'skills' => $request->skills,
                    'social_facebook' => $request->social_facebook,
                    'social_twitter' => $request->social_twitter,
                    'social_linkedin' => $request->social_linkedin,
                    'avatar' => $avatarPath,
                ]
            );
            
            return redirect()->route('profile.show', $user->id)->with('success', 'تم تحديث الملف الشخصي بنجاح');
        } catch (\Exception $e) {
            \Log::error('Error in profile update: ' . $e->getMessage());
            return back()->withInput()->with('error', 'حدث خطأ أثناء تحديث الملف الشخصي');
        }
    }
    
    /**
     * تحديث كلمة المرور
     */
    public function updatePassword(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $request->validate([
                'current_password' => 'required',
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
            
            $user = auth()->user();
            
            // التحقق من كلمة المرور الحالية
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
            }
            
            // تحديث كلمة المرور
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            
            return redirect()->route('profile.show', $user->id)->with('success', 'تم تغيير كلمة المرور بنجاح');
        } catch (\Exception $e) {
            \Log::error('Error in password update: ' . $e->getMessage());
            return back()->withErrors(['error' => 'حدث خطأ أثناء تحديث كلمة المرور']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
