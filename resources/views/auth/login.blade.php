@extends('layouts.home.login.app')

@section('page-title', 'Login Pasien')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-5">

        <div class="card card-round">

            <div class="card-body p-4">

                <div class="text-center mb-4">

                    <i class="fas fa-user-circle fa-3x text-primary mb-3"></i>

                    <h3 class="fw-bold">
                        Login Pasien
                    </h3>

                    <p class="text-muted">
                        Silakan masuk untuk mengakses layanan Puskesmas Tiku.
                    </p>

                </div>

                @if(session('success'))

                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>

                @endif

                @if(session('error'))

                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>

                @endif

                @if($errors->any())

                    <div class="alert alert-danger">

                        @foreach($errors->all() as $error)

                            <div>
                                {{ $error }}
                            </div>

                        @endforeach

                    </div>

                @endif

                <form
                    action="{{ route('login') }}"
                    method="POST"
                >

                    @csrf

                    <div class="mb-3">

                        <label class="form-label">
                            Username
                        </label>

                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary w-100 btn-round"
                    >
                        <i class="fas fa-sign-in-alt me-1"></i>
                        Login
                    </button>

                </form>

                <div class="text-center mt-3">
    <span>Belum memiliki akun?</span>
    <a href="{{ route('register') }}">
        Daftar sebagai pasien
    </a>
</div>

            </div>

        </div>

    </div>

</div>

@endsection