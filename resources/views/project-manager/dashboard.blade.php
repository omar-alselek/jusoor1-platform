@extends('layouts.app')

@section('title', 'لوحة التحكم لمدير المشروع')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">لوحة التحكم</h1>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <!-- بطاقات الإحصائيات -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 flex items-start">
            <div class="bg-blue-100 p-3 rounded-full ml-4">
                <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">المشاريع</p>
                <h3 class="text-3xl font-bold">{{ $projects }}</h3>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 flex items-start">
            <div class="bg-green-100 p-3 rounded-full ml-4">
                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">المتطوعين</p>
                <h3 class="text-3xl font-bold">{{ $volunteers }}</h3>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 flex items-start">
            <div class="bg-purple-100 p-3 rounded-full ml-4">
                <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm">التبرعات</p>
                <h3 class="text-3xl font-bold">{{ $donations }}</h3>
            </div>
        </div>
    </div>
    
    <!-- القوائم السريعة -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-bold">آخر المشاريع</h2>
            </div>
            <div class="p-6">
                @if($latestProjects->count() > 0)
                <div class="space-y-4">
                    @foreach($latestProjects as $project)
                    <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                        <div class="flex justify-between">
                            <h3 class="font-medium">{{ $project->title }}</h3>
                            <span class="text-sm px-2 py-1 rounded {{ $project->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $project->status }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ $project->location }}</p>
                        <div class="mt-2 text-sm">
                            <span class="text-gray-500">الهدف:</span> 
                            <span class="font-medium">{{ number_format($project->target_amount) }} $</span>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                <div class="bg-teal-600 h-2 rounded-full" style="width: {{ min(100, ($project->current_amount / $project->target_amount) * 100) }}%"></div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('projects.show', $project) }}" class="text-sm text-teal-600 hover:text-teal-800">عرض المشروع &rarr;</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4 text-gray-500">
                    لا توجد مشاريع بعد
                </div>
                @endif
                <div class="mt-4 text-center">
                    <a href="{{ route('project-manager.projects') }}" class="text-teal-600 hover:text-teal-800 text-sm font-medium">
                        عرض كل المشاريع
                    </a>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-bold">روابط سريعة</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <a href="{{ route('project-manager.projects') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 flex items-center">
                        <svg class="h-6 w-6 text-teal-600 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <div>
                            <h3 class="font-medium">إدارة المشاريع</h3>
                            <p class="text-sm text-gray-500">عرض وتعديل المشاريع الخاصة بك</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('project-manager.volunteers') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 flex items-center">
                        <svg class="h-6 w-6 text-teal-600 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <div>
                            <h3 class="font-medium">إدارة المتطوعين</h3>
                            <p class="text-sm text-gray-500">عرض وإدارة طلبات التطوع</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('project-manager.donations') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 flex items-center">
                        <svg class="h-6 w-6 text-teal-600 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="font-medium">التبرعات</h3>
                            <p class="text-sm text-gray-500">عرض وإدارة التبرعات المقدمة للمشاريع</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('projects.create') }}" class="block bg-gray-50 hover:bg-gray-100 p-4 rounded-lg border border-gray-200 flex items-center">
                        <svg class="h-6 w-6 text-teal-600 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <div>
                            <h3 class="font-medium">إنشاء مشروع جديد</h3>
                            <p class="text-sm text-gray-500">إنشاء مشروع جديد للمساهمة في التنمية</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 