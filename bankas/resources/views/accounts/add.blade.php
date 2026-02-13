@extends('layouts.app')

@section('content')

<div class="form-center">
    <div class="form-card">
        <h1>Pridėti lėšų</h1>

        <p><b>{{ $acc['name'] }} {{ $acc['surname'] }}</b></p>
        <p>Likutis: {{ $acc['balance'] }} €</p>

        <form method="POST" action="{{ route('accounts.add.money', $acc['id']) }}">
            @csrf

            <p>Suma:</p>
            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}">

            <br><br>
            <button type="submit">Pridėti</button>
            <a href="{{ route('accounts.index') }}"><button type="button">Grįžti</button></a>
        </form>

    </div>
</div>
@endsection