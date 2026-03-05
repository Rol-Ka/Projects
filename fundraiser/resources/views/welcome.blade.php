@extends('layouts.app')

@section('page','home')

@section('content')

<section class="hero">

<div class="hero-inner">

<h1>Padėk žmonėms pasiekti savo tikslus</h1>

<p>
Fundraiser platforma kur žmonės gali dalintis savo istorijomis ir gauti paramą iš bendruomenės.
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

</section>


<section class="landing-info">

<h2>
Tūkstančiai žmonių jau pasiekė savo tikslus
</h2>

<p>
Pasidalink savo istorija, gauk paramą ir padėk savo svajonėms
tapti realybe.
</p>

</section>

<section class="discover">

<div class="container">

<h2>Discover fundraisers inspired by what you care about</h2>

<div class="discover-grid">

@foreach($stories as $story)

<a href="{{ route('story.show', $story) }}" class="discover-card">

<div class="discover-image">

<img src="{{ asset('storage/'.$story->image) }}" alt="{{ $story->title }}">

<span class="donations">
{{ $story->donations_count }} donations
</span>

</div>

<h3>{{ Str::limit($story->title, 40) }}</h3>

<div class="progress">

{{-- <div class="progress-bar"
style="width: {{ ($story->raised / $story->goal) * 100 }}%">
</div> --}}

</div>

<p class="raised">
€{{ number_format($story->raised) }} raised
</p>

</a>

@endforeach

</div>

</div>

</section>

@endsection
