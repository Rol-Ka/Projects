@extends('layouts.app')

@section('content')

<div class="auth-container">

    <div class="auth-card">

        <h2>Prisijungimas</h2>

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            {{-- EMAIL --}}
            <div class="form-group">
                <label>El. paštas</label>

                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                >

                @error('email')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div class="form-group">
                <label>Slaptažodis</label>

                <input 
                    type="password" 
                    name="password"
                    class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                >

                @error('password')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- REMEMBER --}}
            <div class="form-remember">
                <label>
                    <input type="checkbox" name="remember">
                    Prisiminti mane
                </label>
            </div>

            <button type="submit" class="btn-primary btn-block">
                Prisijungti
            </button>

            <div class="auth-links">
                <a href="{{ route('password.request') }}">
                    Pamiršote slaptažodį?
                </a>
            </div>

        </form>

    </div>

</div>

@endsection