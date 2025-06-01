@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-10">
            <div class="row bg-white rounded-4 shadow-sm overflow-hidden">
                <div class="col-md-6 p-4 p-md-5">
                    <h2 class="fw-bold mb-4">Login</h2>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   placeholder="e.g. admin@admin.com"
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" 
                                   class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="remember" 
                                       name="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg mb-4">
                            Login
                        </button>

                        <p class="text-center mb-0">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-decoration-none">Sign Up</a>
                        </p>
                    </form>
                </div>
                <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center bg-light">
                    <div class="text-center p-4">
                        <h4 class="mb-4">Selamat Datang di Sistem Manajemen Lomba</h4>
                        <p class="text-muted">Silakan login untuk mengakses sistem</p>
                    </div>
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

.form-check-input:checked {
    background-color: #1877f2;
    border-color: #1877f2;
}

.form-label {
    font-weight: 500;
    color: #444;
}
</style>
@endpush
@endsection
