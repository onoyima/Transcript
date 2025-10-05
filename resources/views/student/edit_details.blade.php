@extends('layouts.app')
<title> edits </title>
@section('content')
    <div class="container">
        <h2>Edit Your Profile Details</h2>

        <form method="POST" action="{{ route('student.update.details') }}">
            @csrf
            {{-- <input type="hidden" name="matric_number" value="{{ $student->matric_number }}"> --}}

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $student->email) }}" required>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $student->phone) }}" required>
                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
@endsection
