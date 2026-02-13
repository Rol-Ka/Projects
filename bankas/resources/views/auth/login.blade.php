@extends('layouts.guest')

@section('content')

<h2 class="login-title">Prisijungimas</h2>

<form method="POST" action="{{ route('login') }}" class="login-form">
    @csrf

    <div class="login-row">
        <label>Email</label>
        <input type="text" name="email">
    </div>

    <div class="login-row">
        <label>Slaptažodis</label>
        <input type="password" name="password">
    </div>

    <div class="login-actions">
        <button type="submit" class="login-btn">Prisijungti</button>
    </div>

</form>

@endsection