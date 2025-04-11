@extends('layouts.app')

@section('title', 'Social Feed')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap md:flex-nowrap">
        <!-- Left Sidebar -->
        <div class="w-full md:w-1/4 pr-0 md:pr-6 mb-6 md:mb-0">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">My Profile</h2>
                <div class="flex items-center mb-4">
                    @if(auth()->user()->profile->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->profile->avatar) }}" alt="{{ auth()->user()->name }}" class="w-16 h-16 rounded-full mr-4">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-300 mr-4 flex items-center justify-center text-gray-700 text-xl font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="font-bold">{{ auth()->user()->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ auth()->user()->profile->location ?? 'No location set' }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.show', auth()->id()) }}" class="block text-center w-full py-2 px-4 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition">عرض الملف الشخصي</a>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Quick Links</h2>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('social.feed') }}" class="flex items-center text-teal-600 font-medium">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Feed
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('social.friends') }}" class="flex items-center text-gray-700 hover:text-teal-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                                Friends
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('social.friends.suggestions') }}" class="flex items-center text-gray-700 hover:text-teal-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                                </svg>
                                Find Friends
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projects.index') }}" class="flex items-center text-gray-700 hover:text-teal-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                </svg>
                                Projects
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <!-- Logout Button -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full text-left text-red-600 hover:text-red-800 font-medium py-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="w-full md:w-2/4 mb-6 md:mb-0">
            <!-- Create Post -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Create Post</h2>
                <form action="{{ route('social.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <textarea name="content" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50" placeholder="What's on your mind?"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Add Images (up to 5)</label>
                        <div class="flex flex-col space-y-2">
                            <input type="file" name="images[]" id="images" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                            <div id="image-preview" class="flex flex-wrap gap-2 mt-2"></div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <label for="privacy" class="block text-sm font-medium text-gray-700 mb-1">Privacy</label>
                            <select name="privacy" id="privacy" class="border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                                <option value="public">Public</option>
                                <option value="friends">Friends Only</option>
                            </select>
                        </div>
                        <button type="submit" class="py-2 px-4 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition">Post</button>
                    </div>
                </form>
            </div>
            
            <!-- Posts Feed -->
            <div class="space-y-6">
                @forelse($posts as $post)
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <!-- Post Header -->
                        <div class="flex items-center mb-4">
                            @if($post->user->profile->avatar)
                                <img src="{{ asset('storage/' . $post->user->profile->avatar) }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full mr-4">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-300 mr-4 flex items-center justify-center text-gray-700 text-md font-bold">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold">{{ $post->user->name }}</h3>
                                <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            
                            @if($post->user_id === auth()->id())
                            <div class="ml-auto">
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                        <a href="{{ route('social.posts.edit', $post) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Post</a>
                                        <form action="{{ route('social.posts.destroy', $post) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100" onclick="return confirm('Are you sure you want to delete this post?')">Delete Post</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Post Content -->
                        <div class="mb-4">
                            <p class="text-gray-800 whitespace-pre-line">{{ $post->content }}</p>
                            
                            @if($post->images)
                                @php
                                    // تحويل محتوى الصور إلى مصفوفة في حالة كان مخزن كـ JSON
                                    $images = is_array($post->images) ? $post->images : json_decode($post->images);
                                    $imagesCount = is_array($images) ? count($images) : 0;
                                @endphp
                                
                                @if($imagesCount > 0)
                                <div class="mt-4 grid grid-cols-{{ min($imagesCount, 3) }} gap-2">
                                    @foreach($images as $image)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Post image" class="rounded-md w-full h-48 object-cover">
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            @endif
                        </div>
                        
                        <!-- Post Actions -->
                        <div class="flex items-center justify-between border-t border-b py-2 mb-4">
                            <form action="{{ route('social.posts.like', $post) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center text-gray-500 hover:text-teal-600 {{ $post->isLikedBy(auth()->id()) ? 'text-teal-600' : '' }}">
                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                    </svg>
                                    <span>{{ $post->likes->count() }} {{ Str::plural('Like', $post->likes->count()) }}</span>
                                </button>
                            </form>
                            
                            <button type="button" class="flex items-center text-gray-500 hover:text-teal-600 comment-toggle" data-target="comment-form-{{ $post->id }}">
                                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $post->comments->count() }} {{ Str::plural('Comment', $post->comments->count()) }}</span>
                            </button>
                        </div>
                        
                        <!-- Comments Section -->
                        <div class="mb-2">
                            @foreach($post->comments->take(3) as $comment)
                            <div class="flex mb-4 comment-container" id="comment-{{ $comment->id }}">
                                @if($comment->user->profile->avatar)
                                    <img src="{{ asset('storage/' . $comment->user->profile->avatar) }}" alt="{{ $comment->user->name }}" class="w-8 h-8 rounded-full mr-3">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-300 mr-3 flex items-center justify-center text-gray-700 text-sm font-bold">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="bg-gray-100 rounded-lg py-2 px-3 flex-grow">
                                    <div class="flex justify-between items-start">
                                        <p class="font-semibold text-sm">{{ $comment->user->name }}</p>
                                        <div class="flex items-center">
                                            <p class="text-xs text-gray-500 mx-2">{{ $comment->created_at->diffForHumans() }}</p>
                                            
                                            @if($comment->user_id === auth()->id())
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open" class="text-gray-500 hover:text-gray-700">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                                    </svg>
                                                </button>
                                                <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-32 bg-white rounded-md shadow-lg py-1 z-10">
                                                    <button type="button" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 edit-comment-btn" data-comment-id="{{ $comment->id }}">تعديل</button>
                                                    <form action="{{ route('social.comments.delete', $comment) }}" method="POST" class="delete-comment-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100" onclick="return confirm('هل أنت متأكد من حذف هذا التعليق؟')">حذف</button>
                                                    </form>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-sm mt-1 comment-content">{{ $comment->content }}</p>
                                    
                                    <!-- نموذج تعديل التعليق - مخفي افتراضيًا -->
                                    <form action="{{ route('social.comments.update', $comment) }}" method="POST" class="edit-comment-form hidden mt-2" id="edit-form-{{ $comment->id }}">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="content" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 text-sm" placeholder="تعديل التعليق...">{{ $comment->content }}</textarea>
                                        <div class="flex justify-end mt-2">
                                            <button type="button" class="py-1 px-3 bg-gray-200 text-gray-700 text-sm rounded-md hover:bg-gray-300 transition mr-2 cancel-edit-btn" data-comment-id="{{ $comment->id }}">إلغاء</button>
                                            <button type="submit" class="py-1 px-3 bg-teal-600 text-white text-sm rounded-md hover:bg-teal-700 transition">تحديث</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            
                            @if($post->comments->count() > 3)
                            <div class="text-center mb-4">
                                <a href="{{ route('social.posts.show', $post) }}" class="text-sm text-teal-600 hover:text-teal-800">View all {{ $post->comments->count() }} comments</a>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Comment Form -->
                        <form id="comment-form-{{ $post->id }}" action="{{ route('social.posts.comment', $post) }}" method="POST" class="hidden">
                            @csrf
                            <div class="flex">
                                @if(auth()->user()->profile->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->profile->avatar) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full mr-3">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-300 mr-3 flex items-center justify-center text-gray-700 text-sm font-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="flex-grow">
                                    <textarea name="content" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 text-sm" placeholder="Write a comment..."></textarea>
                                    <div class="text-right mt-2">
                                        <button type="submit" class="py-1 px-3 bg-teal-600 text-white text-sm rounded-md hover:bg-teal-700 transition">Comment</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No posts yet</h3>
                    <p class="mt-1 text-gray-500">Be the first to share something with the community!</p>
                </div>
                @endforelse
                
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
        
        <!-- Right Sidebar -->
        <div class="w-full md:w-1/4 pl-0 md:pl-6">
            <!-- Friend Suggestions -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">People You May Know</h2>
                <div class="space-y-4">
                    @php
                    $suggestions = App\Models\User::where('id', '!=', auth()->id())
                        ->inRandomOrder()
                        ->limit(5)
                        ->get();
                    @endphp
                    
                    @forelse($suggestions as $user)
                    <div class="flex items-center">
                        @if($user->profile && $user->profile->avatar)
                            <img src="{{ asset('storage/' . $user->profile->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full mr-3">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-300 mr-3 flex items-center justify-center text-gray-700 text-md font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="flex-grow">
                            <h3 class="font-semibold">{{ $user->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $user->profile && $user->profile->location ? $user->profile->location : 'No location' }}</p>
                        </div>
                        <form action="{{ route('social.friends.request', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-teal-600 hover:text-teal-800 text-sm font-medium">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @empty
                    <p class="text-gray-500 text-sm">No suggestions available.</p>
                    @endforelse
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('social.friends.suggestions') }}" class="text-sm text-teal-600 hover:text-teal-800">See More</a>
                </div>
            </div>
            
            <!-- Trending Projects -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Trending Projects</h2>
                <div class="space-y-4">
                    @php
                    $projects = App\Models\Project::where('status', 'active')
                        ->orderBy('created_at', 'desc')
                        ->limit(3)
                        ->get();
                    @endphp
                    
                    @forelse($projects as $project)
                    <div class="border-b pb-4 last:border-b-0 last:pb-0">
                        <h3 class="font-semibold">{{ $project->title }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ Str::limit($project->description, 80) }}</p>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ $project->location }}</span>
                            <span>{{ number_format(($project->current_amount / $project->target_amount) * 100, 0) }}% funded</span>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('projects.show', $project) }}" class="text-sm text-teal-600 hover:text-teal-800">View Project →</a>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-sm">No active projects available.</p>
                    @endforelse
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('projects.index') }}" class="text-sm text-teal-600 hover:text-teal-800">View All Projects</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // إضافة مستمع أحداث لجميع أزرار التعليق
        document.querySelectorAll('.comment-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const formId = this.getAttribute('data-target');
                const form = document.getElementById(formId);
                if (form) {
                    // تبديل حالة الظهور للنموذج
                    if (form.classList.contains('hidden')) {
                        form.classList.remove('hidden');
                    } else {
                        form.classList.add('hidden');
                    }
                }
            });
        });

        // معاينة الصور المحددة قبل الرفع
        const imageInput = document.getElementById('images');
        const imagePreview = document.getElementById('image-preview');

        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', function() {
                // إفراغ منطقة المعاينة أولاً
                imagePreview.innerHTML = '';
                
                // الحد الأقصى هو 5 صور
                const maxImages = 5;
                let fileCount = 0;
                
                // إنشاء معاينة لكل ملف محدد
                Array.from(this.files).forEach(file => {
                    if (fileCount >= maxImages) return;
                    fileCount++;
                    
                    if (!file.type.match('image.*')) return;
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgContainer = document.createElement('div');
                        imgContainer.className = 'relative';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-20 h-20 object-cover rounded-md border border-gray-300';
                        imgContainer.appendChild(img);
                        
                        imagePreview.appendChild(imgContainer);
                    }
                    reader.readAsDataURL(file);
                });
                
                // إظهار معاينة الصور
                imagePreview.style.display = this.files.length > 0 ? 'flex' : 'none';
            });
        }
        
        // تعديل التعليقات
        document.querySelectorAll('.edit-comment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const editForm = document.getElementById(`edit-form-${commentId}`);
                
                // إظهار نموذج التعديل
                if (editForm) {
                    // إخفاء محتوى التعليق الأصلي
                    const commentContainer = this.closest('.comment-container');
                    const contentElement = commentContainer.querySelector('.comment-content');
                    contentElement.classList.add('hidden');
                    
                    // إظهار نموذج التعديل
                    editForm.classList.remove('hidden');
                    
                    // التركيز على مجال النص
                    editForm.querySelector('textarea').focus();
                }
            });
        });
        
        // إلغاء تعديل التعليق
        document.querySelectorAll('.cancel-edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const editForm = document.getElementById(`edit-form-${commentId}`);
                
                if (editForm) {
                    // إخفاء نموذج التعديل
                    editForm.classList.add('hidden');
                    
                    // إظهار محتوى التعليق الأصلي
                    const commentContainer = this.closest('.comment-container');
                    const contentElement = commentContainer.querySelector('.comment-content');
                    contentElement.classList.remove('hidden');
                }
            });
        });
        
        // التعامل مع حذف التعليق باستخدام AJAX
        document.querySelectorAll('.delete-comment-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('هل أنت متأكد من حذف هذا التعليق؟')) {
                    const url = this.getAttribute('action');
                    const commentContainer = this.closest('.comment-container');
                    
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // حذف عنصر التعليق من DOM
                            commentContainer.remove();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        });
        
        // التعامل مع تعديل التعليق باستخدام AJAX
        document.querySelectorAll('.edit-comment-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const url = this.getAttribute('action');
                const commentContainer = this.closest('.comment-container');
                const contentElement = commentContainer.querySelector('.comment-content');
                const newContent = this.querySelector('textarea').value;
                
                fetch(url, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        content: newContent
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // تحديث محتوى التعليق في DOM
                        contentElement.textContent = newContent;
                        
                        // إخفاء نموذج التعديل
                        this.classList.add('hidden');
                        
                        // إظهار محتوى التعليق المحدث
                        contentElement.classList.remove('hidden');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
@endsection
