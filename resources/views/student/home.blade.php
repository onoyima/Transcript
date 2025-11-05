@extends('layouts.apps')

@section('content')
    <!-- ===== Sidebar Start ===== -->
    <!-- Sidebar content can go here if needed -->
    <!-- ===== Sidebar End ===== -->

    <!-- ===== Content Area Start ===== -->
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center">
        <div class="text-center bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl max-w-[460px] w-full space-y-6">
            
            <!-- Header Section -->
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">
                Verify Your Identity
            </h1>
            <p class="text-lg text-black dark:text-gray-300 mb-6">
                Please select one of the methods below to verify your identity and continue with your registration.
            </p>
            
            <!-- Verify with Matric Number Button -->
            <div class="mb-4">
                <a href="{{ route('student.matric.form') }}" 
                   class="inline-block bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold py-3 px-6 rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-primary-500 transition duration-300 transform hover:scale-105">
                    Verify with Matric Number
                </a>
            </div>
            
            <!-- Verify with Security Questions Button -->
            <div class="mb-4">
                <a href="{{ route('student.security.questions') }}" 
                   class="inline-block bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-300 transform hover:scale-105">
                    Verify with Security Questions
                </a>
            </div>

            <!-- Instructions or Info Section -->
            <div class="mt-6">
                <p class="text-gray-900 dark:text-white text-sm">
                    Need help? Please contact support at <span class="font-semibold text-primary-600 dark:text-primary-400">ictsupport@veritas.edu.ng</span> for assistance.
                </p>
            </div>

        </div>
    </div>
    <!-- ===== Content Area End ===== -->
@endsection
