
@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>

    <div class="mt-5">
        <h3 class="font-semibold">Order Details:</h3>
        <p><strong>Total Amount:</strong> ${{ $order->total_amount }}</p>
        <p><strong>GST (18%):</strong> ${{ $order->gst }}</p>
        <p><strong>Grand Total:</strong> ${{ $order->grand_total }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
    </div>

    <h3 class="mt-5 font-semibold">Order Items:</h3>
    <table class="min-w-full mt-5">
        <thead>
            <tr>
                <th class="px-4 py-2">Product</th>
                <th class="px-4 py-2">Quantity</th>
                <th class="px-4 py-2">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td class="px-4 py-2">{{ $item->product->name }}</td>
                <td class="px-4 py-2">{{ $item->quantity }}</td>
                <td class="px-4 py-2">${{ $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
