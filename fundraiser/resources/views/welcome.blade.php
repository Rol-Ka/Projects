@extends('layouts.app')

@section('page','home')

@section('content')

<section class="hero">

<div class="hero-inner">

<h1>Padėk žmonėms pasiekti savo tikslus</h1>

<p>
PaaukokMan platforma kur žmonės gali dalintis savo istorijomis ir gauti paramą iš bendruomenės.
</p>

<div class="hero-buttons">
<a href="{{ route('fundraiser.start') }}" class="btn-primary">Pradėti rinkti paramą</a>
<a href="{{ route('stories.index') }}" class="btn-secondary">Peržiūrėti istorijas</a>
</div>

</div>

</section>


<section class="hero-gallery">

<div class="hero-slider swiper">

<div class="swiper-wrapper">

<div class="swiper-slide">
<img src="/images/hero1.jpg">
</div>

<div class="swiper-slide">
<img src="/images/hero2.jpg">
</div>

<div class="swiper-slide">
<img src="/images/hero3.jpg">
</div>

<div class="swiper-slide">
<img src="/images/hero4.jpg">
</div>

<div class="swiper-slide">
<img src="/images/hero5.jpg">
</div>

<div class="swiper-slide">
<img src="/images/hero6.jpg">
</div>

<div class="swiper-slide">
<img src="/images/hero7.jpg">
</div>

</div> 

</div> 

</section>


<section class="landing-info">

<h2>
Tūkstančiai žmonių jau pasiekė savo tikslus
</h2>

<p>
Istorijos, kurios įkvepia, ir bendruomenė, kuri palaiko. Padėk žmonėms pasiekti savo svajones paaukodamas. Kartu galime kurti geresnį pasaulį.
</p>

</section>


<section class="discover">

<div class="container">


<div class="discover-grid">

@foreach($activeStories as $story)

<a href="{{ route('story.show', $story) }}" class="story-link">
    <div class="story-card">

    @if($story->main_image)
        <div class="story-image-wrap">
            <img src="{{ asset('storage/'.$story->main_image) }}">
        </div>
    @endif

    <div class="story-body">

        <h3 class="story-title">
            {{ $story->title }}
        </h3>

        <p class="story-content">
            {{ Str::limit($story->content, 90) }}
        </p>

        @php
    $current = $story->current_amount;
    $goal = $story->goal_amount;
@endphp

@include('components.progress')

        <div class="story-money">

    <div class="story-amounts">
        <span class="raised">
            €{{ number_format($story->current_amount, 0) }}
        </span>
        <span class="goal">
            iš €{{ number_format($story->goal_amount, 0) }}
        </span>
    </div>

    <div class="story-left">
        Liko €{{ number_format($goal - $current, 0) }}
    </div>

</div>

        
        <div class="story-footer">
            
        </div>

    </div>

</div>
</a>

@endforeach

</div>
<div class="hero-buttons-bottom">

<a href="{{ route('stories.index') }}" class="btn-secondary">Peržiūrėti visas istorijas</a>
</div>
</div>

</section>
<section class="landing-info">

<h2>
Tavo istorija gali pakeisti viską
</h2>

<p>
Pasidalink savo keliu, įkvėpk žmones ir leisk bendruomenei prisidėti prie tavo svajonės. Kiekviena didelė istorija prasideda nuo pirmo žingsnio.
</p>
</section>

<section class="discover">

<div class="container">

<div class="discover-grid">

@foreach($completedStories as $story)

<a href="{{ route('story.show', $story) }}" class="story-link">
    <div class="story-card">

    @if($story->main_image)
        <div class="story-image-wrap">
            <img src="{{ asset('storage/'.$story->main_image) }}">
        </div>
    @endif

    <div class="story-body">

        <h3 class="story-title">
            {{ $story->title }}
        </h3>

        <p class="story-content">
            {{ Str::limit($story->content, 90) }}
        </p>

        @php
    $current = $story->current_amount;
    $goal = $story->goal_amount;
@endphp

@include('components.progress')

        <div class="story-money">

    <div class="story-amounts">
        <span class="raised">
            €{{ number_format($story->current_amount, 0) }}
        </span>
        <span class="goal">
            iš €{{ number_format($story->goal_amount, 0) }}
        </span>
    </div>

    <div class="story-left">
        Liko €{{ number_format($goal - $current, 0) }}
    </div>

</div>
        <div class="story-footer">
            
        </div>

    </div>

</div>
</a>

@endforeach

</div>
<div class="hero-buttons-bottom">

<a href="{{ route('fundraiser.start') }}" class="btn-primary">Pradėti rinkti paramą</a>
</div>
</div>

</section>

@endsection
