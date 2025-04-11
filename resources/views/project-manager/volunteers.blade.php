@extends('layouts.app')

@section('title', 'إدارة المتطوعين')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">إدارة المتطوعين</h1>
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

    <!-- فلتر البحث -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">بحث وفلترة</h2>
        <form action="{{ route('project-manager.volunteers') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">بحث</label>
                <input type="text" name="search" id="search" placeholder="اسم المتطوع أو المهارات" value="{{ request('search') }}" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500">
            </div>
            <div>
                <label for="project" class="block text-sm font-medium text-gray-700 mb-1">المشروع</label>
                <select name="project" id="project" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="">كل المشاريع</option>
                    @foreach(auth()->user()->projects as $project)
                        <option value="{{ $project->id }}" {{ request('project') == $project->id ? 'selected' : '' }}>{{ $project->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">الحالة</label>
                <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="">كل الحالات</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>مقبول</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    تطبيق الفلتر
                </button>
                <a href="{{ route('project-manager.volunteers') }}" class="mr-2 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    إعادة ضبط
                </a>
            </div>
        </form>
    </div>

    <!-- جدول المتطوعين -->
    <div class="bg-white overflow-hidden shadow-md rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">رقم</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">البريد الإلكتروني</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المشروع</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الساعات</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المهارات</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التاريخ</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($volunteers as $volunteer)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $volunteer->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $volunteer->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $volunteer->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $volunteer->project->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $volunteer->hours ?? 'غير محدد' }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500">{{ $volunteer->skills }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $volunteer->status == 'approved' ? 'bg-green-100 text-green-800' : 
                                      ($volunteer->status == 'rejected' ? 'bg-red-100 text-red-800' : 
                                      'bg-yellow-100 text-yellow-800') }}">
                                    {{ $volunteer->status == 'approved' ? 'مقبول' : 
                                      ($volunteer->status == 'rejected' ? 'مرفوض' : 'قيد الانتظار') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $volunteer->created_at->format('Y/m/d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                @if($volunteer->status == 'pending')
                                    <form action="{{ route('project-manager.volunteers.approve', $volunteer) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('هل أنت متأكد من قبول طلب التطوع؟')" 
                                            class="text-green-600 hover:text-green-900 ml-2">قبول</button>
                                    </form>
                                    <form action="{{ route('project-manager.volunteers.reject', $volunteer) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('هل أنت متأكد من رفض طلب التطوع؟')" 
                                            class="text-red-600 hover:text-red-900">رفض</button>
                                    </form>
                                @endif
                                <a href="{{ route('project-manager.volunteers.show', $volunteer) }}" class="text-teal-600 hover:text-teal-900 ml-2">تفاصيل</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-6">
                                    <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="mt-2 text-sm">لا يوجد متطوعين في الوقت الحالي</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            {{ $volunteers->links() }}
        </div>
    </div>
</div>
@endsection 