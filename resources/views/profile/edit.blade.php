@extends('layouts.app') {{-- Pastikan meng-extend layout Anda --}}

@section('content')
<h1 class="text-2xl font-bold mb-6">Profile Pengguna</h1>

<div class="space-y-6">
    {{-- Bagian Update Profile Information --}}
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Bagian Update Password --}}
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Bagian Delete User (Opsional, bisa dihapus jika tidak mau user bisa delete akun sendiri) --}}
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection