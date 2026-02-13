@extends('layouts.app')

@section('content')
<div class="form-center">
    <div class="form-card">
        <h1>Nauja sąskaita</h1>

        <form method="POST" action="{{ route('accounts.store') }}">
            @csrf

            <p>Vardas:</p>
            <input type="text" name="name"
                value="{{ old('name') }}"
                class="input {{ $errors->has('name') ? 'input-error' : '' }}">
            @error('name')
            <div style="color:red">{{ $message }}</div>
            @enderror


            <p>Pavardė:</p>
            <input type="text" name="surname"
                value="{{ old('surname') }}"
                class="input {{ $errors->has('surname') ? 'input-error' : '' }}">
            @error('surname')
            <div style="color:red">{{ $message }}</div>
            @enderror


            <p>Asmens kodas:</p>
            <input type="text" name="personal_code"
                value="{{ old('personal_code') }}"
                class="input {{ $errors->has('personal_code') ? 'input-error' : '' }}">
            @error('personal_code')
            <div style="color:red">{{ $message }}</div>
            @enderror

            <p>Sąskaitos numeris (IBAN):</p>
            <input type="text" value="{{ $iban }}" readonly>
            <input type="hidden" name="iban" value="{{ $iban }}">

            <br><br>
            <button type="submit">Sukurti</button>
        </form>
    </div>
</div>
@endsection