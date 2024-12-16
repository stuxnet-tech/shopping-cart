@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold">Create Product</h1>
    
    <form action="{{ route('products.store') }}" method="POST" class="mt-4" enctype="multipart/form-data">
        @csrf
        
        <!-- Product Name Field -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Product Name</label>
            <input type="text" name="name" id="name" class="form-input mt-1 block w-full" value="{{ old('name') }}" required>
            <!-- Display validation error for name -->
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price Field -->
        <div class="mb-4">
            <label for="price" class="block text-sm font-medium">Price</label>
            <input type="number" name="price" id="price" class="form-input mt-1 block w-full" value="{{ old('price') }}" required>
            <!-- Display validation error for price -->
            @error('price')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Quantity Field -->
        <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-input mt-1 block w-full" value="{{ old('quantity') }}" required>
            <!-- Display validation error for quantity -->
            @error('quantity')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description Field -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium">Description</label>
            <textarea name="description" id="description" class="form-input mt-1 block w-full">{{ old('description') }}</textarea>
            <!-- Display validation error for description -->
            @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Images Field -->
        <div class="mb-4">
            <label for="images" class="block text-sm font-medium">Product Images</label>
            <input type="file" name="images[]" class="form-input mt-1 block w-full" multiple>
            <!-- Display validation error for images -->
            @error('images')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
            @error('images.*')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
</div>
@endsection
