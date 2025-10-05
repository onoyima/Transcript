@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Admin Dashboard</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Application Status</th>
                        <th>Payment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                        <tr>
                            <td>{{ $application->student_id }}</td>
                            <td>{{ $application->application_status }}</td>
                            <td>{{ $application->payment_status }}</td>
                            <td>
                                <form action="{{ url('admin/update-status/'.$application->id) }}" method="POST">
                                    @csrf
                                    <div class="d-flex">
                                        <select name="application_status" class="form-control me-2">
                                            <option value="Started" {{ $application->application_status == 'Started' ? 'selected' : '' }}>Started</option>
                                            <option value="In Progress" {{ $application->application_status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="Completed" {{ $application->application_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                        <select name="payment_status" class="form-control me-2">
                                            <option value="Pending" {{ $application->payment_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Completed" {{ $application->payment_status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="Failed" {{ $application->payment_status == 'Failed' ? 'selected' : '' }}>Failed</option>
                                        </select>
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
