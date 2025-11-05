@extends('layouts.staff')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Admin Dashboard
        </h2>
        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium text-primary" href="{{ route('transcript.staff.dashboard') }}">Dashboard /</a>
                </li>
                <li class="font-medium text-primary">Admin</li>
            </ol>
        </nav>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5 mb-6">
        <!-- Total Applications -->
        <div class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                <i class="fas fa-file-alt text-primary text-xl"></i>
            </div>
            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-black dark:text-white">
                        {{ $stats['total_applications'] }}
                    </h4>
                    <span class="text-sm font-medium">Total Applications</span>
                </div>
            </div>
        </div>

        <!-- Pending Applications -->
        <div class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-6 dark:bg-meta-4">
                <i class="fas fa-clock text-warning text-xl"></i>
            </div>
            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-black dark:text-white">
                        {{ $stats['pending_applications'] }}
                    </h4>
                    <span class="text-sm font-medium">Pending Applications</span>
                </div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-3 dark:bg-meta-4">
                <i class="fas fa-spinner text-info text-xl"></i>
            </div>
            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-black dark:text-white">
                        {{ $stats['in_progress_applications'] }}
                    </h4>
                    <span class="text-sm font-medium">In Progress</span>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-5 dark:bg-meta-4">
                <i class="fas fa-check-circle text-success text-xl"></i>
            </div>
            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-black dark:text-white">
                        {{ $stats['completed_applications'] }}
                    </h4>
                    <span class="text-sm font-medium">Completed</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="py-6 px-4 md:px-6 xl:px-7.5">
            <h4 class="text-xl font-semibold text-black dark:text-white">
                All Transcript Applications
            </h4>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Student
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Application Status
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Payment Status
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Created Date
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                    <tr>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                                        <span class="text-white font-semibold text-sm">
                                            {{ strtoupper(substr($application->student->first_name ?? 'N', 0, 1) . substr($application->student->last_name ?? 'A', 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-black dark:text-white font-medium">
                                        {{ $application->student->first_name ?? 'N/A' }} {{ $application->student->last_name ?? '' }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        ID: {{ $application->student_id }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                            <span class="inline-flex rounded-full px-3 py-1 text-sm font-medium
                                @if($application->application_status == 'Started') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                @elseif($application->application_status == 'In Progress') bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400
                                @elseif($application->application_status == 'Completed') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400 @endif">
                                {{ $application->application_status }}
                            </span>
                        </td>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                            <span class="inline-flex rounded-full px-3 py-1 text-sm font-medium
                                @if($application->payment_status == 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                @elseif($application->payment_status == 'Completed') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                @elseif($application->payment_status == 'Failed') bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400 @endif">
                                {{ $application->payment_status }}
                            </span>
                        </td>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                            <p class="text-black dark:text-white">
                                {{ $application->created_at->format('M d, Y') }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $application->created_at->format('h:i A') }}
                            </p>
                        </td>
                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                            <button onclick="openUpdateModal({{ $application->id }}, '{{ $application->application_status }}', '{{ $application->payment_status }}')"
                                    class="inline-flex items-center justify-center rounded-md bg-primary py-2 px-4 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-8 transition-all duration-200">
                                <i class="fas fa-edit mr-2"></i>
                                Update Status
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="border-b border-[#eee] py-8 px-4 text-center dark:border-strokedark">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-500 dark:text-gray-400">No applications found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div id="updateModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="mx-4 w-full max-w-md rounded-lg bg-white p-6 dark:bg-boxdark">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-black dark:text-white">Update Application Status</h3>
            <button onclick="closeUpdateModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="updateForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                    Application Status
                </label>
                <select name="application_status" id="applicationStatus" 
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                    <option value="Started">Started</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                    Payment Status
                </label>
                <select name="payment_status" id="paymentStatus"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                    <option value="Failed">Failed</option>
                </select>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeUpdateModal()"
                        class="flex-1 rounded border border-stroke py-2 px-6 text-center font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 rounded bg-primary py-2 px-6 text-center font-medium text-white hover:bg-opacity-90">
                    Update Status
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openUpdateModal(applicationId, currentAppStatus, currentPayStatus) {
    document.getElementById('updateForm').action = `/transcript/staff/admin/update-status/${applicationId}`;
    document.getElementById('applicationStatus').value = currentAppStatus;
    document.getElementById('paymentStatus').value = currentPayStatus;
    document.getElementById('updateModal').classList.remove('hidden');
    document.getElementById('updateModal').classList.add('flex');
}

function closeUpdateModal() {
    document.getElementById('updateModal').classList.add('hidden');
    document.getElementById('updateModal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('updateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUpdateModal();
    }
});
</script>
@endsection