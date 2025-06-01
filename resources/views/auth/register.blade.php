@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-10">
            <div class="row bg-white rounded-4 shadow-sm overflow-hidden">
                <div class="col-md-6 p-4 p-md-5">
                    <h2 class="fw-bold mb-4">Register</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Masukkan nama lengkap"
                                   required 
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="contoh: nama@email.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" 
                                   class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password"
                                   placeholder="Minimal 6 karakter"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                            <input type="password" 
                                   class="form-control form-control-lg" 
                                   id="password-confirm" 
                                   name="password_confirmation"
                                   placeholder="Ketik ulang password"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg mb-4">
                            Register
                        </button>

                        <p class="text-center mb-0">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
                        </p>
                    </form>
                </div>
                <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center bg-light">
                    <img src="{{ asset('images/rooster-mascot.png') }}" alt="Rooster Mascot" class="img-fluid" style="max-width: 80%;">
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
body {
    background-color: #f0f2f5;
}

.form-control {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    border: 1px solid #ced4da;
}

.form-control:focus {
    border-color: #1877f2;
    box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
}

.btn-primary {
    background-color: #1877f2;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    padding: 0.75rem;
}

.btn-primary:hover {
    background-color: #166fe5;
}
</style>
@endpush
@endsection
