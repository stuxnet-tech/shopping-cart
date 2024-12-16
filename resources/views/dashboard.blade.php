@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">

    @if(session('success'))
    <div class="mt-3 bg-green-500 text-white p-2 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-3 gap-4 mt-5">
        @foreach($products as $product)
        <div class="border p-4 rounded-lg">
            <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
            <p class="mt-2">Price: ${{ $product->price }}</p>
            <p class="mt-2">Stock: {{ $product->stock }}</p>
            <p class="mt-2">{{ $product->description }}</p>

            <div class="mt-4">
                @foreach($product->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image" class="w-full h-auto mb-2">
                @endforeach
            </div>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <div class="flex items-center">
                    <label for="quantity" class="mr-2">Quantity:</label>
                    <input type="number" name="stock" id="quantity" value="1" min="1" class="border rounded px-2 py-1 w-20">
                </div>
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Add to Cart</button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
