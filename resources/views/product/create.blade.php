@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold">Create Product</h1>
    
    <form action="{{ route('products.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Product Name</label>
            <input type="text" name="name" id="name" class="form-input mt-1 block w-full" value="{{ old('name') }}" required>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-sm font-medium">Price</label>
            <input type="number" name="price" id="price" class="form-input mt-1 block w-full" value="{{ old('price') }}" required>
        </div>

        <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-input mt-1 block w-full" value="{{ old('quantity') }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium">Description</label>
            <textarea name="description" id="description" class="form-input mt-1 block w-full">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
</div>
@endsection
