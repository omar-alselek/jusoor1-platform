@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-teal-600 font-semibold tracking-wide uppercase">About Jusoor</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Our Mission and Vision</p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">Learn more about our platform dedicated to connecting Syrians and supporting development efforts.</p>
            </div>
            
            <div class="prose prose-lg mx-auto text-gray-500">
                <p>Jusoor ("Bridges" in Arabic) is a platform designed to connect Syrians inside and outside the country, facilitating collaboration on development and reconstruction projects. Our mission is to harness the collective power, skills, and resources of the Syrian community worldwide to contribute to the country's future.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8">Our Story</h2>
                <p>Jusoor was born out of a recognition that despite geographical distances, Syrians around the world share a common desire to contribute to their homeland's development. Many skilled professionals, entrepreneurs, and simply concerned citizens living abroad want to help but lack the connections and infrastructure to do so effectively.</p>
                
                <p>Similarly, individuals and organizations working on important projects inside Syria often lack access to international expertise, funding, or other resources that could amplify their impact.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8">What We Do</h2>
                <ul class="mt-4 list-disc space-y-2 pl-5">
                    <li><strong>Connect people:</strong> We bring together Syrians from all walks of life and locations, creating a virtual community focused on positive change.</li>
                    <li><strong>Facilitate projects:</strong> We provide a platform for initiating, funding, and managing development and reconstruction projects.</li>
                    <li><strong>Share knowledge:</strong> We enable the exchange of expertise, best practices, and lessons learned across borders.</li>
                    <li><strong>Mobilize resources:</strong> We help channel financial contributions, volunteer efforts, and in-kind support to where they're most needed.</li>
                </ul>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8">Our Values</h2>
                <ul class="mt-4 list-disc space-y-2 pl-5">
                    <li><strong>Inclusivity:</strong> We welcome Syrians of all backgrounds, beliefs, and political views who share a commitment to positive development.</li>
                    <li><strong>Transparency:</strong> We ensure that all project information, including funding and progress, is clearly communicated.</li>
                    <li><strong>Empowerment:</strong> We believe in enabling local communities to lead their own development.</li>
                    <li><strong>Sustainability:</strong> We focus on long-term, sustainable solutions rather than short-term fixes.</li>
                    <li><strong>Innovation:</strong> We encourage creative approaches to addressing challenges.</li>
                </ul>
                
                <h2 class="text-2xl font-bold text-gray-900 mt-8">Join Us</h2>
                <p>Whether you're a Syrian living abroad with skills to contribute, someone working on development projects inside Syria, or simply interested in supporting positive change, we invite you to join the Jusoor community.</p>
                
                <p>Together, we can build bridges that connect people, ideas, and resources for a better future.</p>
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    Join Our Community
                </a>
            </div>
        </div>
    </div>
@endsection 