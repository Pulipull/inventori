<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('browser_title')
            @yield('browser_title')
        @elseif (trim($__env->yieldContent('title')))
            @yield('title') - NexStock
        @else
            NexStock
        @endif
    </title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('brand/nexstock-logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-slate-900 antialiased">
@auth
    <div class="min-h-screen lg:flex">
        <x-dashboard.sidebar :user="auth()->user()" />

        <div class="min-w-0 flex-1">
            <x-dashboard.navbar :user="auth()->user()" />

            <main class="px-4 py-6 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
                @endif
                @if (session('info'))
                    <div class="mb-4 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700">{{ session('info') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">{{ $errors->first() }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
@else
    @yield('content')
@endauth
</body>
</html>
