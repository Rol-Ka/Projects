@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 600px;">

    <h2>Sukurti istoriją</h2>

    @if(session('error'))
        <div style="color:red; margin-bottom:10px;">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('story.store') }}" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom:10px;">
            <label>Pavadinimas</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div style="margin-bottom:10px;">
            <label>Aprašymas</label>
            <textarea name="content" class="form-control" required></textarea>
        </div>

        <div style="margin-bottom:10px;">
            <label>Tikslinė suma (€)</label>
            <input type="number" step="0.01" name="goal_amount" class="form-control" required>
        </div>

        <div style="margin-bottom:10px;">
            <label>Pagrindinė nuotrauka</label>
            <input type="file" name="main_image" class="form-control">
        </div>
       <div style="margin-bottom:10px;">
    <label>#Tag (rašyk su #, pvz: #kelione #pagalba)</label>
    <input type="text" name="tags_text" class="form-control" placeholder="#kelione #auka">
</div>

        <button type="submit">
            Sukurti
        </button>

    </form>

</div>
@endsection