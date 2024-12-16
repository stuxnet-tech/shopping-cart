@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h2 class="text-xl font-semibold">Create New User</h2>

    <form action="{{ route('users.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full p-2 border border-gray-300 rounded-md" required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full p-2 border border-gray-300 rounded-md" required>
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-medium">Role</label>
                <select id="role" name="role" class="w-full p-2 border border-gray-300 rounded-md">
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4 flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Create User</button>
            </div>
        </div>
    </form>
</div>
@endsection
