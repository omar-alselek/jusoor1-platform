@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-teal-700">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1569407228235-96f49fb0115f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80" alt="Syrian landscape">
            <div class="absolute inset-0 bg-teal-700 mix-blend-multiply"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Jusoor Platform</h1>
            <p class="mt-6 max-w-3xl text-xl text-teal-100">Connecting Syrians inside and outside the country, facilitating collaboration on development and reconstruction projects.</p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-teal-700 bg-white hover:bg-teal-50">
                    Browse Projects
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-teal-600 hover:bg-teal-500">
                    Join the Community
                </a>
            </div>
        </div>
    </div>

    <!-- Feature Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-teal-600 font-semibold tracking-wide uppercase">Our Platform Features</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Building bridges for a better future</p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">Connect, collaborate, and contribute to projects that matter for Syria's development and reconstruction.</p>
            </div>

            <div class="mt-10">
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-teal-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-medium text-gray-900">Community Networking</h3>
                            <p class="mt-2 text-base text-gray-500">Connect with Syrians from all around the world, share experiences, and build lasting relationships.</p>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-teal-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-medium text-gray-900">Development Projects</h3>
                            <p class="mt-2 text-base text-gray-500">Browse, support, or create development projects that contribute to Syria's reconstruction and future.</p>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-teal-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-medium text-gray-900">Volunteer Opportunities</h3>
                            <p class="mt-2 text-base text-gray-500">Find volunteer opportunities that match your skills and contribute to meaningful projects.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Projects Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-teal-600 font-semibold tracking-wide uppercase">Featured Projects</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Make a difference today</p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">Explore some of our featured development and reconstruction projects.</p>
            </div>

            <div class="mt-6 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                {{-- Show example projects for now --}}
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="h-48 w-full overflow-hidden bg-teal-100 flex items-center justify-center">
                        <svg class="h-12 w-12 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">School Reconstruction Project</h3>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            Damascus, Syria
                        </div>
                        <p class="mt-3 text-gray-500 line-clamp-3">Rebuilding schools in affected areas to ensure education continues for the next generation.</p>
                        <div class="mt-4">
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-2 mb-2 text-xs flex rounded bg-teal-200">
                                    <div style="width:65%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-teal-500"></div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">$65,000 raised</span>
                                    <span class="text-gray-900">$100,000 goal</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('projects.index') }}" class="text-teal-600 hover:text-teal-500 font-medium">View Project <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="h-48 w-full overflow-hidden bg-teal-100 flex items-center justify-center">
                        <svg class="h-12 w-12 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Medical Supplies Initiative</h3>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            Aleppo, Syria
                        </div>
                        <p class="mt-3 text-gray-500 line-clamp-3">Providing essential medical supplies to hospitals and clinics throughout Syria.</p>
                        <div class="mt-4">
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-2 mb-2 text-xs flex rounded bg-teal-200">
                                    <div style="width:80%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-teal-500"></div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">$40,000 raised</span>
                                    <span class="text-gray-900">$50,000 goal</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('projects.index') }}" class="text-teal-600 hover:text-teal-500 font-medium">View Project <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="h-48 w-full overflow-hidden bg-teal-100 flex items-center justify-center">
                        <svg class="h-12 w-12 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Cultural Heritage Preservation</h3>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            Palmyra, Syria
                        </div>
                        <p class="mt-3 text-gray-500 line-clamp-3">Documenting and preserving Syria's rich cultural heritage through digital archiving and restoration projects.</p>
                        <div class="mt-4">
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-2 mb-2 text-xs flex rounded bg-teal-200">
                                    <div style="width:30%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-teal-500"></div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">$15,000 raised</span>
                                    <span class="text-gray-900">$50,000 goal</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('projects.index') }}" class="text-teal-600 hover:text-teal-500 font-medium">View Project <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    View All Projects
                </a>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="bg-teal-700">
        <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Ready to make a difference?</span>
            </h2>
            <p class="mt-4 text-lg leading-6 text-teal-100">Join our community and start contributing to the future of Syria by connecting, sharing knowledge, or supporting important projects.</p>
            <div class="mt-8 flex justify-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-teal-700 bg-white hover:bg-teal-50">
                    Sign Up Now
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-teal-600">
                    Sign In
                </a>
            </div>
        </div>
    </div>
@endsection 