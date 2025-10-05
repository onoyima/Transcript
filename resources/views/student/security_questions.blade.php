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
                Please enter your details to proceed.
            </p>

            <!-- Flash Messages for Success/Failure -->
            @if (session('success'))
                <div class="alert alert-success text-green-600 p-3 mb-4 rounded-lg bg-green-100">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger text-red-600 p-3 mb-4 rounded-lg bg-red-100">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Section: Verify with Matric Number and Other Details -->
            <div class="mb-4">
                <form action="{{ route('student.security.verify') }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Surname Input -->
                    <div>
                        <label for="surname" class="text-sm font-semibold text-black dark:text-gray-300">Surname:</label>
                        <input type="text" name="surname" placeholder="Enter Surname" required 
                            class="w-full text-gray-900 dark:text-white bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 font-bold py-3 px-6 rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300">
                    </div>

                    <!-- Date of Birth Input -->
                    <div>
                        <label for="dob" class="text-sm font-semibold text-black dark:text-gray-300">Date of Birth:</label>
                        <input type="text" name="dob" placeholder="YYYY-MM-DD" required 
                            class="w-full text-gray-900 dark:text-white bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 font-bold py-3 px-6 rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300">
                    </div>

                    <!-- Program Selection -->
                    <div>
                        <label for="program_id" class="text-sm font-semibold text-black dark:text-gray-300">Select Program:</label>
                        <select name="program_id" required 
                            class="w-full text-gray-900 dark:text-white bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 py-3 px-6 rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300">
                            <option value="">Select Program</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 px-6 mt-4 bg-primary-600 hover:bg-primary-700 text-white rounded-full transition duration-300 shadow-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                        Submit
                    </button>

                    <!-- Form Validation Errors -->
                    @error('surname')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                    @error('dob')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                    @error('program_id')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </form>
            </div>

            <!-- Instructions or Info Section -->
            <div class="mt-6">
                <p>
                    <a href="{{ route('student.security.questions') }}" class="text-indigo-600 hover:underline">Can't remember your Matriculation Number?</a>
                </p>
                <p class="text-black text-sm mt-2">
                    Need help? Please contact support at <span class="font-semibold text-indigo-600">ictsupport@veritas.edu.ng</span> for assistance.
                </p>
            </div>

        </div>
    </div>
    <!-- ===== Content Area End ===== -->
@endsection
