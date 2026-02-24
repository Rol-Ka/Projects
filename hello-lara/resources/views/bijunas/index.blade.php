
@extends('tevas')

@section('turinys')

<h1 id="myButton"> Zydi kieme bijunai </h1>
@if ($skaicius > 5)
<h2> Bijunai yra labai gražūs! </h2>
@else
<h2> Bijunai yra gražūs, bet galėtų būti ir daugiau! </h2>
@endif
    <p> Bijunai yra labai gražūs ir spalvingi. </p>
<p> Bijunai yra labai svarbūs, nes jie saugo kiemą nuo piktų dvasių ir blogos energijos. </p>
<p> Jie taip pat simbolizuoja stiprybę, ištikimybę ir apsaugą. </p>
@include('bijunas.gele')
<p> Bijunai dažnai yra pagaminti iš keramikos arba akmens, ir jie gali būti įvairių dydžių ir formų. </p>
<p> Jie dažnai yra dekoruoti įvairiais raštais ir simboliais, kurie turi
ypatingą reikšmę. </p>
<p> Bijunai yra ne tik gražūs, bet ir turi gilią simbolinę reikšmę, todėl jie yra svarbi dalis daugelio kultūrų ir tradicijų. </p>
<ul>
@foreach($geles as $gele)
    <li>{{ $gele }} </li>
@endforeach
</ul>
@endsection

@section('pavadinimas') Zydi kieme bijunas @endsection