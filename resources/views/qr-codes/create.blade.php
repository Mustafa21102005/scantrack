@extends('layouts.app')

@section('title', 'Create Qr Code')

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Create Qr Code</h4>

                <x-error-alert />

                <form class="forms-sample" method="POST" action="{{ route('qr-codes.store') }}">
                    @csrf

                    {{-- expires_at --}}
                    <div class="form-group">
                        <label for="expires_at">Expires At</label>
                        <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                            id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                    </div>

                    {{-- course_id --}}
                    <div class="form-group">
                        <label for="course_id">Course</label>
                        <select class="form-control @error('course_id') is-invalid @enderror" id="course_id"
                            name="course_id" required>
                            <option value="" disabled {{ request('course_id') ? '' : 'selected' }}>Select a course
                            </option>
                            @forelse($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @empty
                                <option disabled>No courses assigned to you.</option>
                            @endforelse
                        </select>
                    </div>

                    <x-primary-button type="submit">Create</x-primary-button>
                    <x-secondary-button href="{{ route('qr-codes.index') }}">Cancel</x-secondary-button>
                </form>
            </div>
        </div>
    </div>
@endsection
