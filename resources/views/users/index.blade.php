@extends('layouts.app')
 
@section('content')

    <div class="flex justify-between">
        <h1 class="text-2xl font-bold">Users</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-2">Create Users</a>
    </div>

    {{ $dataTable->table() }}
@endsection
 
@push('scripts')
    {{ $dataTable->scripts() }}
@endpush