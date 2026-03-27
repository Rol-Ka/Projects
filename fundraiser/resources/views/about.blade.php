@extends('layouts.app')


@section('content')

<div class="about">

    <section class="about-hero">
        <div class="container-sm">

            <h1>
                Paversk istoriją <span>realiu pokyčiu</span>
            </h1>

            <p>
                Platforma, kur žmonės dalinasi savo istorijomis
                ir bendruomenė padeda jas paversti realybe.
            </p>

            <div class="about-actions">
                <a href="{{ route('story.create') }}" class="btn-primary">
                    Sukurti istoriją
                </a>

                <a href="{{ route('stories.index') }}" class="btn-secondary">
                    Peržiūrėti istorijas
                </a>
            </div>

        </div>
    </section>

    <section class="about-stats">
        <div class="container">

            <div class="stats-grid">

                <div class="stat">
                    <h3>100+</h3>
                    <p>Istorijų</p>
                </div>

                <div class="stat">
                    <h3>€10K+</h3>
                    <p>Surinkta</p>
                </div>

                <div class="stat">
                    <h3>500+</h3>
                    <p>Narių</p>
                </div>

            </div>

        </div>
    </section>

    <section class="about-features">
        <div class="container">

            <div class="features-grid">

                <div class="feature-card">
                    <h3>⚡ Greita pradžia</h3>
                    <p>Sukuri istoriją per kelias minutes.</p>
                </div>

                <div class="feature-card">
                    <h3>🔍 Skaidrumas</h3>
                    <p>Visas progresas aiškiai matomas.</p>
                </div>

                <div class="feature-card">
                    <h3>🤝 Bendruomenė</h3>
                    <p>Žmonės padeda žmonėms.</p>
                </div>

                <div class="feature-card">
                    <h3>💚 Tikras poveikis</h3>
                    <p>Maži veiksmai → dideli pokyčiai.</p>
                </div>

            </div>

        </div>
    </section>

    <section class="about-how">
        <div class="container">

            <h1>Kaip tai veikia?</h1>

            <div class="how-grid">

                <div class="how-card ">
                    <span>1</span>
                    <h3>Sukuri istoriją</h3>
                </div>

                <div class="how-card">
                    <span>2</span>
                    <h3>Žmonės pamato</h3>
                </div>

                <div class="how-card">
                    <span>3</span>
                    <h3>Gauni palaikymą</h3>
                </div>

            </div>

        </div>
    </section>

    <section class="about-testimonials">
        <div class="container-sm">

            <div class="testimonial">
                „Ši platforma padėjo man pasiekti tikslą,
                kurio vienas nebūčiau įgyvendinęs.“
            </div>

        </div>
    </section>

    <section class="about-cta">
        <div class="container-sm">

            <h2>Pradėk šiandien</h2>

            <p>Prisijunk prie bendruomenės ir kurk pokytį.</p>

            <a href="{{ route('story.create') }}" class="btn-primary">
                Pradėti
            </a>

        </div>
    </section>

</div>

@endsection