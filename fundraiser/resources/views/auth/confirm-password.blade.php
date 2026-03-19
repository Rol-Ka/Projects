@extends('layouts.app')

@section('content')

<div class="auth-container">

    <div class="auth-card">

        <h2>Patvirtinkite slaptažodį</h2>

        <p class="auth-subtext">
            Tai saugi zona. Įveskite slaptažodį tęsti.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" novalidate>
            @csrf

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

            <button class="btn-primary btn-block">Patvirtinti</button>

        </form>

    </div>

</div>

@endsection