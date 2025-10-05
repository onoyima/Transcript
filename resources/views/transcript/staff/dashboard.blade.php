@extends('layouts.app')

@section('title', 'Staff Dashboard - Transcript System')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <h1 class="h3 mb-2 text-white">Staff Dashboard</h1>
                            <p class="mb-2 text-white-50">Welcome back, {{ $staff->full_name }}</p>
                            <div class="d-flex flex-wrap gap-3 text-sm">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope me-2"></i>
                                    <span>{{ $staff->email }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-phone me-2"></i>
                                    <span>{{ $staff->phone ?? 'N/A' }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-tag me-2"></i>
                                    <span>{{ $staff->username }}</span>
                                </div>
                                @if($staff->department)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-building me-2"></i>
                                    <span>{{ $staff->department }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($roles as $role)
                                <span class="badge bg-light text-dark">{{ $role->display_name }}</span>
                                @endforeach
                            </div>
                            <form method="POST" action="{{ route('transcript.staff.logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        @can('view_transcript_applications', $staff)
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total_applications'] ?? 0 }}</h4>
                            <p class="card-text">Total Applications</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['pending_applications'] ?? 0 }}</h4>
                            <p class="card-text">Pending Applications</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        
        @can('view_transcript_payments', $staff)
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['completed_payments'] ?? 0 }}</h4>
                            <p class="card-text">Completed Payments</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">₦{{ number_format($stats['total_revenue'] ?? 0, 2) }}</h4>
                            <p class="card-text">Total Revenue</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-naira-sign fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        
        @can('manage_transcript_staff', $staff)
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['active_staff'] ?? 0 }}</h4>
                            <p class="card-text">Active Staff</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        
        <!-- General stats for all staff -->
        <div class="col-md-3">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total_students'] ?? 0 }}</h4>
                            <p class="card-text">Total Students</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-graduation-cap fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @can('view_transcript_applications', Auth::guard('transcript_staff')->user())
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('transcript.staff.applications') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                <i class="fas fa-file-alt fa-2x mb-2"></i>
                                <span>View Applications</span>
                            </a>
                        </div>
                        @endcan

                        @can('manage_transcript_payments', Auth::guard('transcript_staff')->user())
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('transcript.staff.payments') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                <i class="fas fa-credit-card fa-2x mb-2"></i>
                                <span>Manage Payments</span>
                            </a>
                        </div>
                        @endcan

                        @can('generate_transcript_reports', Auth::guard('transcript_staff')->user())
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('transcript.staff.reports') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                <span>Generate Reports</span>
                            </a>
                        </div>
                        @endcan

                        @can('manage_transcript_staff', Auth::guard('transcript_staff')->user())
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('transcript.staff.manage') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <span>Manage Staff</span>
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Applications</h5>
                </div>
                <div class="card-body">
                    @if(isset($recent_applications) && $recent_applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Application ID</th>
                                        <th>Student</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_applications as $application)
                                    <tr>
                                        <td><strong>#{{ $application->id }}</strong></td>
                                        <td>{{ $application->student->full_name ?? 'N/A' }}</td>
                                        <td>{{ ucfirst($application->type) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $application->status === 'pending' ? 'warning' : ($application->status === 'approved' ? 'success' : 'danger') }}">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('transcript.staff.applications.show', $application->id) }}" class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No recent applications found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">System Notifications</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-bell text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1 small">System maintenance scheduled for tonight at 11 PM</p>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-info"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1 small">New payment gateway integration completed</p>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1 small">Database backup completed successfully</p>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection