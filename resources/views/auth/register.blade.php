@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen bg-gray-50 py-16">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Create a new account</h2>
            <p class="mt-2 text-sm text-gray-600">
                Or <a href="{{ route('login') }}" class="font-medium text-teal-600 hover:text-teal-500">login to your existing account</a>
            </p>
        </div>
        
        <div class="bg-white py-8 px-6 shadow-lg rounded-lg">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" autocomplete="name" required
                            value="{{ old('name') }}"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm @error('name') border-red-500 @enderror">
                        
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            value="{{ old('email') }}"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm @error('email') border-red-500 @enderror">
                        
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm @error('password') border-red-500 @enderror">
                        
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Are you Syrian?</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input id="is_syrian_yes" name="is_syrian" type="radio" value="1" {{ old('is_syrian') == '1' ? 'checked' : '' }} required
                                class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300">
                            <label for="is_syrian_yes" class="ml-2 block text-sm text-gray-900">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input id="is_syrian_no" name="is_syrian" type="radio" value="0" {{ old('is_syrian') == '0' ? 'checked' : '' }} required
                                class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300">
                            <label for="is_syrian_no" class="ml-2 block text-sm text-gray-900">No</label>
                        </div>
                    </div>
                    @error('is_syrian')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="current_country" class="block text-sm font-medium text-gray-700">Current Country</label>
                    <div class="mt-1">
                        <input id="current_country" name="current_country" type="text" required
                            value="{{ old('current_country') }}"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm @error('current_country') border-red-500 @enderror">
                        
                        @error('current_country')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-8">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 