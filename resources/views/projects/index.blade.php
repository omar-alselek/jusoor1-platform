@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-teal-600 font-semibold tracking-wide uppercase">Projects</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Explore Development Projects</p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">Discover projects that are making a difference in Syria's development and reconstruction.</p>
            </div>
            
            <div class="mt-6 flex justify-between items-center">
                <div>
                    @auth
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            Create New Project
                        </a>
                    @endauth
                </div>
                
                <div>
                    <!-- Filter options could go here -->
                </div>
            </div>

            <div class="mt-6 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse($projects as $project)
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="h-48 w-full overflow-hidden">
                        @if($project->image)
                            <img class="w-full h-full object-cover" src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }}">
                        @else
                            <div class="w-full h-full bg-teal-100 flex items-center justify-center">
                                <svg class="h-12 w-12 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $project->title }}</h3>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            {{ $project->location }}
                        </div>
                        <p class="mt-3 text-gray-500 line-clamp-3">{{ $project->description }}</p>
                        <div class="mt-4">
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-2 mb-2 text-xs flex rounded bg-teal-200">
                                    @php
                                        $percentage = $project->target_amount > 0 ? min(($project->current_amount / $project->target_amount) * 100, 100) : 0;
                                    @endphp
                                    <div style="width:{{ $percentage }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-teal-500"></div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">${{ number_format($project->current_amount, 0) }} raised</span>
                                    <span class="text-gray-900">${{ number_format($project->target_amount, 0) }} goal</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('projects.show', $project) }}" class="text-teal-600 hover:text-teal-500 font-medium">View Project <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No projects available</h3>
                    <p class="mt-1 text-gray-500">Check back soon for new projects or create one yourself.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
@endsection 