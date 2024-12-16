
@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold">My Orders</h1>

    @if(session('success'))
    <div class="mt-3 bg-green-500 text-white p-2 rounded">
        {{ session('success') }}
    </div>
    @endif

    <table class="min-w-full mt-5">
        <thead>
            <tr>
                <th class="px-4 py-2">Order ID</th>
                <th class="px-4 py-2">Total Amount</th>
                <th class="px-4 py-2">GST</th>
                <th class="px-4 py-2">Grand Total</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td class="px-4 py-2">{{ $order->id }}</td>
                <td class="px-4 py-2">${{ $order->total_amount }}</td>
                <td class="px-4 py-2">${{ $order->gst }}</td>
                <td class="px-4 py-2">${{ $order->grand_total }}</td>
                <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('orders.show', $order->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
