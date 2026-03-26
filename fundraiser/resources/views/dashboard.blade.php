@extends('layouts.app')

@section('content')

<div class="container-sm dashboard">

    <h2 class="dashboard-title">Mano paskyra</h2>

    @php
        $story = auth()->user()->story;
    @endphp

    {{-- ❌ NETURI STORY --}}
    @if(!$story)

        <div class="dashboard-card empty">

            <p class="dashboard-text">
                Jūs dar neturite savo istorijos.
            </p>

            <p class="dashboard-sub">
                Sukurkite ją ir pradėkite rinkti paramą.
            </p>

            <div class="dashboard-actions">
                <a href="{{ route('story.create') }}" class="btn-primary">
                    Sukurti istoriją
                </a>

                <a href="{{ route('stories.index') }}" class="btn-secondary">
                    Peržiūrėti istorijas
                </a>
            </div>

        </div>

    @endif


    {{-- ✅ TURI STORY --}}
    @if($story)

        <div class="dashboard-card">

            <div class="dashboard-header">

                <h3>Mano istorija</h3>

                <div class="dashboard-status">
                    @if($story->is_approved)
                        <span class="status approved">Patvirtinta</span>
                    @else
                        <span class="status pending">Nepatvirtinta</span>
                    @endif
                </div>

            </div>

            {{-- 🔥 reuse iš show --}}
            <div class="story-show-card dashboard-story">

                {{-- LEFT --}}
                <div class="story-left">

                    @if($story->main_image)
                        <div class="story-show-image">
                            <img src="{{ asset('storage/'.$story->main_image) }}">
                        </div>
                    @endif

                </div>

                {{-- RIGHT --}}
                <div class="story-show-content">

                    <h1 class="story-title">{{ $story->title }}</h1>

                    <p class="story-text">
                        {{ Str::limit($story->content, 200) }}
                    </p>


                    <p class="story-raised">
                        €{{ $story->current_amount }} / €{{ $story->goal_amount }}
                    </p>

                    <div class="dashboard-actions">

                        <a href="{{ route('story.show', $story) }}" class="btn-primary">
                            Peržiūrėti
                        </a>

                        @if(!$story->is_approved)
                        <a href="{{ route('story.edit', $story) }}" class="btn-primary">
                            Redaguoti
                        </a>
                        @endif

                        <form method="POST" action="{{ route('story.destroy', $story) }}" class="delete-story-form">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn-delete-story">
        Ištrinti
    </button>
</form>

                    </div>

                </div>

            </div>

        </div>

    @endif
<div id="delete-modal" class="donate-modal">
    <div class="donate-modal-box">

        <div id="delete-confirm">
            <h3>Ištrinti istoriją</h3>
            <p>Ar tikrai norite ištrinti savo istoriją?</p>

            <div class="donate-modal-actions">
                <button id="confirm-delete">Taip</button>
                <button id="cancel-delete">Ne</button>
            </div>
        </div>

        <div id="delete-success" style="display:none;">
            <h3>🗑️ Istorija ištrinta</h3>

            <button id="delete-continue">
                Tęsti (5)
            </button>
        </div>

    </div>
</div>
</div>


@endsection