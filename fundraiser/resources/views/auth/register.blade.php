@extends('layouts.app')

@section('content')

<div class="auth-container">

    <div class="auth-card">

        <h2>Registracija</h2>

        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            {{-- NAME --}}
            <div class="form-group">
                <label>Vardas</label>

                <input 
                    type="text" 
                    name="name"
                    value="{{ old('name') }}"
                    class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                >

                @error('name')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

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

            {{-- CONFIRM --}}
            <div class="form-group">
                <label>Pakartok slaptažodį</label>

                <input 
                    type="password" 
                    name="password_confirmation"
                    class="form-input"
                >
            </div>

            <button type="submit" class="btn-primary btn-block">
                Registruotis
            </button>

            <div class="auth-links">
                <a href="{{ route('login') }}">
                    Jau turi paskyrą?
                </a>
            </div>

        </form>

    </div>

</div>

@endsection