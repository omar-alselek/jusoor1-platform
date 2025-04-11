@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-teal-600 to-cyan-700 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">الملف الشخصي</h1>
        </div>
        
        <div class="p-6">
            <div class="flex flex-wrap md:flex-nowrap">
                <!-- بيانات المستخدم الأساسية -->
                <div class="w-full md:w-1/3 mb-6 md:mb-0 md:pr-6">
                    <div class="text-center mb-6">
                        @if(auth()->user()->profile->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->profile->avatar) }}" alt="{{ auth()->user()->name }}" class="w-32 h-32 rounded-full mx-auto mb-4">
                        @else
                            <div class="w-32 h-32 rounded-full bg-teal-100 mx-auto mb-4 flex items-center justify-center">
                                <span class="text-teal-800 font-bold text-4xl">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <h2 class="text-xl font-bold">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-600">{{ auth()->user()->email }}</p>
                        
                        <div class="mt-4">
                            <a href="{{ route('profile.edit', auth()->user()->id) }}" class="inline-block bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700 transition">تعديل الملف الشخصي</a>
                        </div>
                    </div>
                    
                    <!-- معلومات الاتصال -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-3">معلومات الاتصال</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>{{ auth()->user()->profile->phone ?? 'لم يتم تحديد رقم الهاتف' }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ auth()->user()->profile->location ?? 'لم يتم تحديد الموقع' }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2a4 4 0 014-4h14a4 4 0 014 4v2"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span>{{ auth()->user()->profile->current_country ?? 'لم يتم تحديد البلد الحالي' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- تفاصيل الملف الشخصي -->
                <div class="w-full md:w-2/3">
                    <!-- نبذة تعريفية -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">نبذة تعريفية</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p>{{ auth()->user()->profile->bio ?? 'لم يتم إضافة نبذة تعريفية بعد.' }}</p>
                        </div>
                    </div>
                    
                    <!-- المهارات -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">المهارات</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            @if(auth()->user()->profile->skills)
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', auth()->user()->profile->skills) as $skill)
                                        <span class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full">{{ trim($skill) }}</span>
                                    @endforeach
                                </div>
                            @else
                                <p>لم يتم إضافة مهارات بعد.</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- وسائل التواصل الاجتماعي -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">وسائل التواصل الاجتماعي</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                @if(auth()->user()->profile->social_facebook)
                                    <a href="{{ auth()->user()->profile->social_facebook }}" target="_blank" class="text-blue-600 hover:underline">{{ auth()->user()->profile->social_facebook }}</a>
                                @else
                                    <span class="text-gray-500">لم يتم إضافة حساب فيسبوك</span>
                                @endif
                            </div>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z"/>
                                </svg>
                                @if(auth()->user()->profile->social_twitter)
                                    <a href="{{ auth()->user()->profile->social_twitter }}" target="_blank" class="text-blue-400 hover:underline">{{ auth()->user()->profile->social_twitter }}</a>
                                @else
                                    <span class="text-gray-500">لم يتم إضافة حساب تويتر</span>
                                @endif
                            </div>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-blue-700 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                @if(auth()->user()->profile->social_linkedin)
                                    <a href="{{ auth()->user()->profile->social_linkedin }}" target="_blank" class="text-blue-700 hover:underline">{{ auth()->user()->profile->social_linkedin }}</a>
                                @else
                                    <span class="text-gray-500">لم يتم إضافة حساب لينكد إن</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 