@php
    $percent = $goal > 0 ? ($current / $goal) * 100 : 0;
    $percentRounded = round($percent);
@endphp

<div class="progress-bar">

    <div class="progress-fill 
        @if($percent < 30) progress-fill-low
        @elseif($percent < 70) progress-fill-mid
        @else progress-fill--high
        @endif"
        style="width: {{ max($percent, 3) }}%">
    </div>

    {{-- TEXT --}}
    <span class="progress-text 
        @if($percent < 15) progress-text-outside
        @endif">
        {{ $percentRounded }}%
    </span>

</div>