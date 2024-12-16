@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold">Your Shopping Cart</h1>

    @if(session('success'))
    <div class="mt-3 bg-green-500 text-white p-2 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if(count($cart) > 0)
    <table class="min-w-full mt-5">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left">Product</th>
                <th class="px-4 py-2 text-left">Quantity</th>
                <th class="px-4 py-2 text-left">Price</th>
                <th class="px-4 py-2 text-left">Total</th>
                <th class="px-4 py-2 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $item)
            <tr>
                <td class="px-4 py-2">{{ $item['product']->name }}</td>
                <td class="px-4 py-2">{{ $item['quantity'] }}</td>
                <td class="px-4 py-2">${{ $item['product']->price }}</td>
                <td class="px-4 py-2">${{ $item['product']->price * $item['quantity'] }}</td>
                <td class="px-4 py-2">
                    <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <p><strong>Total:</strong> {{ $totalCartItem }}</p>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Proceed to Checkout</button>
        </form>
    </div>
    @else
    <p>Your cart is empty.</p>
    @endif
</div>
@endsection
