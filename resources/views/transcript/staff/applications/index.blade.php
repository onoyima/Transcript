@extends('layouts.app')

@section('title', 'Transcript Applications - Staff Portal')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">Transcript Applications</h1>
                    <p class="text-muted">Manage and process student transcript applications</p>
                </div>
                <div>
                    <a href="{{ route('transcript.staff.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('transcript.staff.applications') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">All Types</option>
                                <option value="official" {{ request('type') === 'official' ? 'selected' : '' }}>Official</option>
                                <option value="unofficial" {{ request('type') === 'unofficial' ? 'selected' : '' }}>Unofficial</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   placeholder="Student name or matric number" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('transcript.staff.applications') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Applications List</h5>
                </div>
                <div class="card-body">
                    @if(isset($applications) && $applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student</th>
                                        <th>Matric Number</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Payment Status</th>
                                        <th>Applied Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                    <tr>
                                        <td><strong>#{{ $application->id }}</strong></td>
                                        <td>{{ $application->student->full_name ?? 'N/A' }}</td>
                                        <td>{{ $application->student->matric_number ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $application->type === 'official' ? 'primary' : 'secondary' }}">
                                                {{ ucfirst($application->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $application->status === 'pending' ? 'warning' : 
                                                ($application->status === 'approved' ? 'success' : 
                                                ($application->status === 'rejected' ? 'danger' : 'info')) 
                                            }}">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($application->payment)
                                                <span class="badge bg-{{ $application->payment->status === 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($application->payment->status) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">No Payment</span>
                                            @endif
                                        </td>
                                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('transcript.staff.applications.show', $application->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                @if($application->status === 'pending' && Auth::guard('transcript_staff')->user()->hasPermission('manage_transcript_applications'))
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form method="POST" action="{{ route('transcript.staff.applications.update-status', $application->id) }}" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="status" value="processing">
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="fas fa-play text-info"></i> Start Processing
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form method="POST" action="{{ route('transcript.staff.applications.update-status', $application->id) }}" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="status" value="approved">
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="fas fa-check text-success"></i> Approve
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form method="POST" action="{{ route('transcript.staff.applications.update-status', $application->id) }}" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="status" value="rejected">
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="fas fa-times text-danger"></i> Reject
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if(method_exists($applications, 'links'))
                            <div class="d-flex justify-content-center mt-4">
                                {{ $applications->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No applications found</h5>
                            <p class="text-muted">No transcript applications match your current filters.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection