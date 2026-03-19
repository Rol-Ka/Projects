@extends('layouts.app')

@section('content')

<div class="auth-container">

    <div class="auth-card">

        <h2>Naujas slaptažodis</h2>

        <form method="POST" action="{{ route('password.store') }}" novalidate>
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label>El. paštas</label>

                <input 
                    type="email" 
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                >

                @error('email')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

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

            <div class="form-group">
                <label>Pakartok slaptažodį</label>

                <input 
                    type="password" 
                    name="password_confirmation"
                    class="form-input"
                >
            </div>

            <button class="btn-primary btn-block">
                Atnaujinti
            </button>

        </form>

    </div>

</div>

@endsection