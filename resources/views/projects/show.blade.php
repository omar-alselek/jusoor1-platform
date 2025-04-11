@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <span class="sr-only">Home</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <a href="{{ route('projects.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">المشاريع</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">{{ $project->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
            <!-- Image gallery -->
            <div class="mt-6 max-w-2xl mx-auto sm:px-6 lg:max-w-none lg:px-0 lg:mt-0">
                <div class="aspect-w-3 aspect-h-2 rounded-lg overflow-hidden">
                    @if($project->image)
                        <img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-center object-cover">
                    @else
                        <div class="w-full h-full bg-teal-100 flex items-center justify-center">
                            <svg class="h-12 w-12 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Project info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $project->title }}</h1>
                
                <div class="mt-3">
                    <h2 class="sr-only">معلومات المشروع</h2>
                    <div class="flex items-center mt-2">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <p class="ml-2 text-sm text-gray-700">{{ $project->location }}</p>
                    </div>
                    
                    <div class="flex items-center mt-2">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="ml-2 text-sm text-gray-700">تاريخ البدء: {{ $project->start_date->format('Y/m/d') }}</p>
                    </div>
                    
                    <div class="flex items-center mt-2">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="ml-2 text-sm text-gray-700">تاريخ الانتهاء المتوقع: {{ $project->end_date->format('Y/m/d') }}</p>
                    </div>
                    
                    <div class="flex items-center mt-2">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <p class="ml-2 text-sm text-gray-700">حالة المشروع: {{ $project->status }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900">التمويل</h3>
                    <div class="mt-4">
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <span class="text-xs font-medium inline-block py-1 px-2 uppercase rounded-full text-teal-600 bg-teal-200">
                                        {{ min(round(($project->current_amount / $project->target_amount) * 100), 100) }}% مكتمل
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-teal-200">
                                <div style="width:{{ min(($project->current_amount / $project->target_amount) * 100, 100) }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-teal-500"></div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-700 font-medium">${{ number_format($project->current_amount, 0) }} تم جمعه</span>
                                <span class="text-gray-900 font-medium">${{ number_format($project->target_amount, 0) }} الهدف</span>
                            </div>
                        </div>
                    </div>
                    
                    @if(Auth::check())
                    <div class="mt-6">
                        <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            المساهمة في المشروع
                        </a>
                    </div>
                    @else
                    <div class="mt-6">
                        <p class="text-gray-500 mb-3">يرجى تسجيل الدخول للمساهمة في هذا المشروع</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-teal-700 bg-white border-teal-700 hover:bg-teal-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            تسجيل الدخول للمساهمة
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Project description -->
        <div class="mt-12 lg:mt-16 lg:col-span-2">
            <div class="max-w-prose mx-auto">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">وصف المشروع</h2>
                <div class="prose prose-teal prose-lg text-gray-500">
                    {{ $project->description }}
                </div>
            </div>
        </div>

        <!-- Project creator -->
        <div class="mt-12 lg:mt-16">
            <div class="max-w-prose mx-auto">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">منشئ المشروع</h2>
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-teal-500">
                            <span class="text-xl font-medium leading-none text-white">{{ $project->user->name[0] }}</span>
                        </span>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $project->user->name }}</h3>
                        <p class="text-gray-500">{{ $project->user->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar projects -->
        <div class="mt-16 mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">مشاريع مشابهة</h2>
            <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:gap-x-8">
                <!-- Project cards will go here -->
                @foreach($similarProjects as $similarProject)
                <div class="group relative">
                    <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
                        @if($similarProject->image)
                            <img src="{{ asset('storage/'.$similarProject->image) }}" alt="{{ $similarProject->title }}" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                        @else
                            <div class="w-full h-full bg-teal-100 flex items-center justify-center">
                                <svg class="h-12 w-12 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <a href="{{ route('projects.show', $similarProject) }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $similarProject->title }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $similarProject->location }}</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900">${{ number_format($similarProject->current_amount, 0) }} / ${{ number_format($similarProject->target_amount, 0) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection 