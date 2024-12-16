    @extends('layouts.app')

    @section('content')
    <div class="container mx-auto mt-5">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold">Products</h1>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Create Product</a>
        </div>

        @if(session('success'))
        <div class="mt-3 bg-green-500 text-white p-2 rounded">
            {{ session('success') }}
        </div>
        @endif

        {!! $dataTable->table() !!}
    </div>
    @endsection

    @push('scripts')
    {!! $dataTable->scripts() !!}
    @endpush
