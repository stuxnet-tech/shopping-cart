
@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold">Checkout</h1>

    <form action="{{ route('cart.submitCheckout') }}" method="POST" class="mt-5">
        @csrf
        
        <!-- Address -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-semibold">Shipping Address</label>
            <textarea name="address" id="address" rows="4" class="w-full border border-gray-300 p-2 rounded" required></textarea>
        </div>

        <!-- Payment Method -->
        <div class="mb-4">
            <label for="payment_method" class="block text-sm font-semibold">Payment Method</label>
            <select name="payment_method" id="payment_method" class="w-full border border-gray-300 p-2 rounded" required>
                <option value="COD">Cash on Delivery (COD)</option>
            </select>
        </div>

        <!-- Cart Details -->
        <div class="mt-5">
            <h3 class="font-semibold">Order Summary</h3>
            <p><strong>Total:</strong> ${{ number_format($total, 2) }}</p>
            <p><strong>GST (18%):</strong> ${{ number_format($gst, 2) }}</p>
            <p><strong>Grand Total:</strong> ${{ number_format($grandTotal, 2) }}</p>
        </div>

        <!-- Submit -->
        <div class="mt-5">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Place Order</button>
        </div>
    </form>
</div>
@endsection
