@extends('layouts.app')

@section('content')
<div class="grid min-h-screen place-items-center px-4">
    <form method="post" action="{{ route('register') }}" class="w-full max-w-md rounded-lg bg-white p-8 shadow-sm">
        @csrf
        <h1 class="mb-6 text-2xl font-bold">Daftar Petugas</h1>
        <label class="mb-4 block text-sm font-medium">Nama
            <input name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="mb-4 block text-sm font-medium">Email
            <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="mb-4 block text-sm font-medium">Password
            <input name="password" type="password" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <label class="mb-6 block text-sm font-medium">Konfirmasi Password
            <input name="password_confirmation" type="password" required class="mt-1 w-full rounded border-gray-300">
        </label>
        <button class="w-full rounded bg-moss px-4 py-2 font-semibold text-white">Daftar</button>
        <a href="{{ route('login') }}" class="mt-4 block text-center text-sm text-moss">Sudah punya akun</a>
    </form>
</div>
@endsection
