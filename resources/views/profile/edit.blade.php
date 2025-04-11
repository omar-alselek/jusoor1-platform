@extends('layouts.app')

@section('title', 'تعديل الملف الشخصي')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-teal-600 to-cyan-700 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">تعديل الملف الشخصي</h1>
        </div>
        
        <div class="p-6">
            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- المعلومات الشخصية -->
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-semibold mb-4">المعلومات الشخصية</h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- الاسم -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">الاسم</label>
                                    <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- البريد الإلكتروني -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                                    <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- رقم الهاتف -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف</label>
                                    <input type="text" name="phone" id="phone" value="{{ $user->profile->phone ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- الموقع -->
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">الموقع</label>
                                    <input type="text" name="location" id="location" value="{{ $user->profile->location ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600">
                                    @error('location')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- البلد الحالي -->
                                <div>
                                    <label for="current_country" class="block text-sm font-medium text-gray-700 mb-1">البلد الحالي</label>
                                    <input type="text" name="current_country" id="current_country" value="{{ $user->profile->current_country ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600">
                                    @error('current_country')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- صورة الملف الشخصي -->
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-semibold mb-4">صورة الملف الشخصي</h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="mb-4 flex items-center">
                                @if($user->profile && $user->profile->avatar)
                                    <div class="relative w-20 h-20 mr-4">
                                        <img src="{{ asset('storage/' . $user->profile->avatar) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover">
                                    </div>
                                @else
                                    <div class="w-20 h-20 rounded-full bg-gray-200 mr-4 flex items-center justify-center text-gray-500">
                                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                                <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="previewImage(event)">
                                <label for="avatar" class="cursor-pointer px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">اختر صورة</label>
                            </div>
                            <div id="image-preview" class="mt-2 hidden">
                                <img id="preview" class="w-20 h-20 rounded-full object-cover">
                            </div>
                            @error('avatar')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- النبذة التعريفية والمهارات -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4">النبذة التعريفية والمهارات</h2>
                        <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                            <!-- النبذة التعريفية -->
                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">نبذة تعريفية</label>
                                <textarea name="bio" id="bio" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600">{{ $user->profile->bio ?? '' }}</textarea>
                                @error('bio')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- المهارات -->
                            <div>
                                <label for="skills" class="block text-sm font-medium text-gray-700 mb-1">المهارات (يرجى الفصل بفاصلة)</label>
                                <input type="text" name="skills" id="skills" value="{{ $user->profile->skills ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600">
                                <p class="text-sm text-gray-500 mt-1">مثال: برمجة، تصميم، كتابة، تسويق</p>
                                @error('skills')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- وسائل التواصل الاجتماعي -->
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-semibold mb-4">وسائل التواصل الاجتماعي</h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- فيسبوك -->
                                <div>
                                    <label for="social_facebook" class="block text-sm font-medium text-gray-700 mb-1">فيسبوك</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                                            <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                        </span>
                                        <input type="text" name="social_facebook" id="social_facebook" value="{{ $user->profile->social_facebook ?? '' }}" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:outline-none focus:ring-2 focus:ring-teal-600 border border-gray-300">
                                    </div>
                                    @error('social_facebook')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- تويتر -->
                                <div>
                                    <label for="social_twitter" class="block text-sm font-medium text-gray-700 mb-1">تويتر</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z"/>
                                            </svg>
                                        </span>
                                        <input type="text" name="social_twitter" id="social_twitter" value="{{ $user->profile->social_twitter ?? '' }}" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:outline-none focus:ring-2 focus:ring-teal-600 border border-gray-300">
                                    </div>
                                    @error('social_twitter')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- لينكد إن -->
                                <div>
                                    <label for="social_linkedin" class="block text-sm font-medium text-gray-700 mb-1">لينكد إن</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                                            <svg class="h-5 w-5 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                            </svg>
                                        </span>
                                        <input type="text" name="social_linkedin" id="social_linkedin" value="{{ $user->profile->social_linkedin ?? '' }}" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:outline-none focus:ring-2 focus:ring-teal-600 border border-gray-300">
                                    </div>
                                    @error('social_linkedin')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- أزرار الإجراءات -->
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('profile.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">إلغاء</a>
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- تغيير كلمة المرور -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mt-8">
        <div class="bg-gradient-to-r from-teal-600 to-cyan-700 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">تغيير كلمة المرور</h1>
        </div>
        
        <div class="p-6">
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <!-- كلمة المرور الحالية -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور الحالية</label>
                        <input type="password" name="current_password" id="current_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600">
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- كلمة المرور الجديدة -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور الجديدة</label>
                        <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- تأكيد كلمة المرور الجديدة -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">تأكيد كلمة المرور الجديدة</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600">
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- زر تغيير كلمة المرور -->
                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition">تغيير كلمة المرور</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('image-preview');
        preview.src = URL.createObjectURL(event.target.files[0]);
        previewContainer.classList.remove('hidden');
    }
</script>
@endsection 