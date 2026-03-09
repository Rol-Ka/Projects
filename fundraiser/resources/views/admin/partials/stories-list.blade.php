@foreach($stories as $story)

<div class="admin-story">

    <div class="story-image">
        @if($story->main_image)
        <img src="{{ asset('storage/'.$story->main_image) }}" alt="{{ $story->title }}">
        @endif
    </div>

    <div class="story-info">

        <h3>{{ $story->title }}</h3>

        <p class="story-author">
            Autorius: {{ $story->user->name ?? 'Nėra' }}
        </p>

        <p class="story-date">
            Sukurta: {{ $story->created_at->format('Y-m-d H:i') }}
        </p>

        {{-- PROGRESS BAR --}}
        @php
            $percent = $story->goal_amount > 0
            ? ($story->current_amount / $story->goal_amount) * 100
            : 0;
        @endphp

        <div class="story-progress">
            <div class="progress-bar" style="width: {{ min($percent,100) }}%"></div>
        </div>

        <p class="story-raised">
            €{{ number_format($story->current_amount) }} / €{{ number_format($story->goal_amount) }}
        </p>

        <p class="story-status">
        @if($story->completed_at)
            <span class="status-completed">Baigta</span>
        @elseif($story->is_approved)
            <span class="status-approved">Patvirtinta</span>
        @else
            <span class="status-pending">Nepatvirtinta</span>
        @endif
        </p>

       <div class="story-actions">

<a
href="{{ route('story.show',$story) }}"
class="btn-view"
>
Peržiūrėti
</a>


<a
href="{{ route('story.edit',$story) }}"
class="btn-edit"
>
Redaguoti
</a>


@if(!$story->is_approved)

<form method="POST" action="{{ route('admin.stories.approve',$story) }}">
@csrf

<button type="submit" class="btn-approve">
Patvirtinti
</button>

</form>

@endif


<form method="POST" action="{{ route('admin.stories.destroy',$story) }}">

@csrf
@method('DELETE')

<button class="btn-delete">
Ištrinti
</button>

</form>

</div>

    </div>

</div>

@endforeach