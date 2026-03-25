

@extends('layouts.app')

@section('page','create-story')

@section('content')

<div class="container-sm">

<h2>Sukurti istoriją</h2>

@if(session('error'))
<div class="form-error">
{{ session('error') }}
</div>
@endif

<form method="POST" action="{{ route('story.store') }}" enctype="multipart/form-data" class="story-form story-form-create">
@csrf

@include('story._form')

<button type="submit" class="create-btn">
Sukurti
</button>
</form>

</div>

<div id="create-modal" class="donate-modal">
    <div class="donate-modal-box">

        <div id="modal-confirm">
            <h3>Patvirtinti kūrimą</h3>
            <p>Ar tikrai norite sukurti šią istoriją?</p>

            <div class="donate-modal-actions">
                <button id="confirm-create">Taip</button>
                <button id="cancel-create">Ne</button>
            </div>
        </div>

        <div id="modal-success" style="display:none;">
            <h3>✅ Istorija sukurta!</h3>
            <p>Sėkmingai sukūrėte istoriją</p>

            <button id="continue-btn">
                Tęsti (5)
            </button>
        </div>

    </div>
</div>
@endsection