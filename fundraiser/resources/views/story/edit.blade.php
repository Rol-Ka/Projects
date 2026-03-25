@extends('layouts.app')

@section('content')

<div class="container-sm">
<a href="{{ route('dashboard') }}" class="btn btn-view back-btn">
← Atgal
</a>
<h2>Redaguoti istoriją</h2>

<form method="POST" action="{{ route('story.update', $story) }}" enctype="multipart/form-data" class="story-form story-form-edit">
@csrf
@method('PUT')

@include('story._form', ['story' => $story])

<button type="submit" class="create-btn">
Atnaujinti
</button>
</form>

</div>
<div id="edit-modal" class="donate-modal">
    <div class="donate-modal-box">

        <div id="modal-confirm-edit">
            <h3>Patvirtinti atnaujinimą</h3>
            <p>Ar tikrai norite atnaujinti šią istoriją?</p>

            <div class="donate-modal-actions">
                <button id="confirm-edit">Taip</button>
                <button id="cancel-edit">Ne</button>
            </div>
        </div>

        <div id="modal-success-edit" style="display:none;">
            <h3>✅ Istorija atnaujinta!</h3>
            <p>Sėkmingai atnaujinote istoriją</p>

            <button id="continue-edit-btn">
                Tęsti (5)
            </button>
        </div>

    </div>
</div>
@endsection