@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Create Course</h4>

                <x-error-alert />

                <form class="forms-sample" method="POST" action="{{ route('courses.store') }}">
                    @csrf

                    {{-- title --}}
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            placeholder="Title" name="title" value="{{ old('title') }}" required>
                    </div>

                    {{-- description --}}
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="4"
                            name="description" placeholder="Description">{{ old('description') }}</textarea>
                    </div>

                    {{-- lecturer --}}
                    <div class="form-group">
                        <label for="lecturer_id">Lecturer</label>
                        <select class="form-control @error('lecturer_id') is-invalid @enderror" id="lecturer_id"
                            name="lecturer_id" required>
                            <option value="" disabled {{ request('lecturer_id') ? '' : 'selected' }}>Select a lecturer
                            </option>
                            @foreach ($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}"
                                    {{ old('lecturer_id', request('lecturer_id')) == $lecturer->id ? 'selected' : '' }}>
                                    {{ $lecturer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <x-primary-button type="submit">Create</x-primary-button>
                    <x-secondary-button href="{{ route('courses.index') }}">Cancel</x-secondary-button>
                </form>
            </div>
        </div>
    </div>
@endsection
