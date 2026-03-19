@extends('layouts.app')

@section('content')

<div class="auth-container">

    <div class="auth-card">

        <h2>Slaptažodžio atstatymas</h2>

        <p class="auth-subtext">
            Įveskite el. paštą ir atsiųsime atstatymo nuorodą.
        </p>

        @if (session('status'))
            <div class="success-msg">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" novalidate>
            @csrf

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

            <button class="btn-primary btn-block">
                Siųsti nuorodą
            </button>

        </form>

    </div>

</div>

@endsection