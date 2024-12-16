@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold">Import Products</h1>

    @if(session('success'))
    <div class="mt-3 bg-green-500 text-white p-2 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mt-3 bg-red-500 text-white p-2 rounded">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        <div class="mb-4">
            <label for="file" class="block text-sm font-medium">Upload File (CSV/Excel)</label>
            <input type="file" name="file" id="file" class="form-input mt-1 block w-full" required accept=".csv,.xlsx,.xls">
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-primary">Import Products</button>
        </div>
    </form>

    <!-- Link to download the sample file -->
    <div class="mt-5">
        <h3 class="text-lg font-semibold">Download Sample CSV File</h3>
        <p>Download the sample product CSV file to see the correct format:</p>
        <a href="{{ route('download.sample') }}" class="text-blue-500">Download Sample File</a>
    </div>
</div>
@endsection
