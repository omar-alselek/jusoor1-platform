@extends('layouts.app')

@section('title', 'تفاصيل المتطوع')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('project-manager.volunteers') }}" class="inline-flex items-center text-teal-600 hover:text-teal-800">
            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            العودة إلى قائمة المتطوعين
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h1 class="text-2xl font-bold text-gray-900">تفاصيل المتطوع</h1>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- معلومات المتطوع -->
                <div class="col-span-2">
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4">معلومات المتطوع</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">الاسم</p>
                                <p class="font-medium">{{ $volunteer->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">البريد الإلكتروني</p>
                                <p class="font-medium">{{ $volunteer->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">تاريخ التسجيل</p>
                                <p class="font-medium">{{ $volunteer->created_at->format('Y/m/d') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">الحالة</p>
                                <p class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $volunteer->status == 'approved' ? 'bg-green-100 text-green-800' : 
                                      ($volunteer->status == 'rejected' ? 'bg-red-100 text-red-800' : 
                                      'bg-yellow-100 text-yellow-800') }}">
                                    {{ $volunteer->status == 'approved' ? 'مقبول' : 
                                      ($volunteer->status == 'rejected' ? 'مرفوض' : 'قيد الانتظار') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4">تفاصيل التطوع</h2>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">المهارات</p>
                            <p class="font-medium">{{ $volunteer->skills }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">التوفر</p>
                            <p class="font-medium">{{ $volunteer->availability ?: 'غير محدد' }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">ملاحظات</p>
                            <p class="font-medium">{{ $volunteer->notes ?: 'لا توجد ملاحظات' }}</p>
                        </div>
                    </div>
                    
                    @if($volunteer->status == 'pending')
                    <div class="flex space-x-2 space-x-reverse justify-end mt-6">
                        <form action="{{ route('project-manager.volunteers.approve', $volunteer) }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('هل أنت متأكد من قبول طلب التطوع؟')" 
                                class="py-2 px-4 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                قبول الطلب
                            </button>
                        </form>
                        <form action="{{ route('project-manager.volunteers.reject', $volunteer) }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('هل أنت متأكد من رفض طلب التطوع؟')" 
                                class="py-2 px-4 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                رفض الطلب
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                
                <!-- معلومات المشروع -->
                <div>
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4">معلومات المشروع</h2>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">عنوان المشروع</p>
                            <p class="font-medium">{{ $volunteer->project->title }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">الموقع</p>
                            <p class="font-medium">{{ $volunteer->project->location }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">الحالة</p>
                            <p class="font-medium">{{ $volunteer->project->status }}</p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('projects.show', $volunteer->project) }}" class="text-teal-600 hover:text-teal-800 flex items-center">
                                عرض المشروع
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 