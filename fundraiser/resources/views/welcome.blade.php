@extends('layouts.app')

@section('page','home')

@section('content')

<section class="hero">

<div class="hero-content">

<h1>
Padėk žmonėms pasiekti savo tikslus
</h1>

<p>
Fundraiser platforma kur žmonės gali dalintis savo istorijomis
ir gauti paramą iš bendruomenės.
</p>

<div class="hero-buttons">

<a href="{{ route('fundraiser.start') }}" class="btn-primary">
Pradėti rinkti paramą
</a>

<a href="{{ route('stories.index') }}" class="btn-secondary">
Peržiūrėti istorijas
</a>

</div>

</div>

</section>


<section class="hero-images">

<img src="/images/hero1.jpg">
<img src="/images/hero2.jpg">
<img src="/images/hero3.jpg">

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

@endsection
