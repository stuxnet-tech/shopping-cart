<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
        @stack('styles')

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Impersonation Alert -->
            @if(session()->has('original_user_id'))
                <div class="bg-warning text-white text-center py-2">
                    You are impersonating <strong>{{ Auth::user()->name }}</strong>. 
                    <a href="{{ route('impersonate.stop') }}" class="text-dark font-bold">Stop Impersonation</a>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                <div class="container-fluid p-5">
                    @yield('content')
                </div>
                <!-- jQuery -->
                <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
                <!-- Bootstrap JS -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                <!-- DataTables JS -->
                <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
            </main>
            @stack('scripts')
        </div>
    </body>
</html>