@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">Edit Profile</div>

                <div class="card-body">
                    <!-- Show success message -->
                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success">
                            Profile updated successfully!
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Profile Image Display -->
                        <div class="text-center mb-3">
                            @if ($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}"
                                     alt="Profile Image" class="rounded-circle" width="150" height="150">
                            @else
                                <img src="{{ asset('images/default-image.webp') }}"
                                     alt="Default Avatar" class="rounded-circle" width="150" height="150">
                            @endif
                        </div>

                        <!-- Image Upload Field -->
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control">
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Update Profile</button>
                        </div>
                    </form>

                    <!-- Delete Account -->
                    <hr>
                    <form action="{{ route('profile.destroy') }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete your account?');">
                        @csrf
                        @method('DELETE')

                        <div class="mb-3">
                            <label for="password" class="form-label">Confirm Password to Delete</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger">Delete Account</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
