@extends('layouts.apps')

@section('content')
    <!-- ===== Sidebar Start ===== -->
    <!-- Sidebar content can go here if needed -->
    <!-- ===== Sidebar End ===== -->

    <!-- ===== Content Area Start ===== -->
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center">
        <div class="text-center bg-white p-8 rounded-lg shadow-xl max-w-[460px] w-full space-y-6">

            <!-- Header Section -->
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">
                Verify Your Identity
            </h1>
            <p class="text-lg text-black dark:text-gray-300 mb-6">
                Please enter your Matriculation Number to proceed.
            </p>

            <!-- Form Section: Verify with Matric Number -->
            <div class="mb-4">
                <form action="{{ route('student.matric.process') }}" method="POST" class="space-y-4">
                    
                    @csrf
                    <!-- Matriculation Number Input -->
                    @error('matric_number')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <input type="text" id="matric_number" name="matric_number" placeholder="Enter Matric Number (e.g VUG/HIS/2011/901)" required
                        class="w-full text-gray-900 dark:text-white bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 font-bold py-3 px-6 rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 transform hover:scale-105">
                    
                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 px-6 mt-4 bg-warning-500 text-black rounded-full hover:bg-warning-500 transition duration-300">
                        Submit
                    </button>

                   
                </form>



                
            </div>

            <!-- Instructions or Info Section -->
            <div class="mt-6">
                <p>
                    <a href="{{ route('student.security.questions') }}" class="text-black-600 hover:underline">Can't remember your Matriculation Number?</a>
                </p>
                <p class="text-black text-sm mt-2">
                    Need help? Please contact support at <span class="font-semibold text-indigo-600">ictsupport@veritas.edu.ng</span> for assistance.
                </p>
            </div>

        </div>
    </div>
    <!-- ===== Content Area End ===== -->
@endsection
