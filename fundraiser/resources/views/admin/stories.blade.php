@extends('layouts.admin')

@section('content')

<div class="admin-stories container">

<h2>Istorijos</h2>

<div class="admin-filters">

<div class="filter-status">

<a href="{{ route('admin.stories',[
'search'=>request('search'),
'sort'=>request('sort')
]) }}"
class="{{ !request('status') ? 'active-filter' : '' }}">
Visos
</a>

<a href="{{ route('admin.stories',[
'status'=>'pending',
'search'=>request('search'),
'sort'=>request('sort')
]) }}"
class="{{ request('status')=='pending' ? 'active-filter' : '' }}">
Nepatvirtintos
</a>

<a href="{{ route('admin.stories',[
'status'=>'approved',
'search'=>request('search'),
'sort'=>request('sort')
]) }}"
class="{{ request('status')=='approved' ? 'active-filter' : '' }}">
Patvirtintos
</a>

<a href="{{ route('admin.stories',[
'status'=>'completed',
'search'=>request('search'),
'sort'=>request('sort')
]) }}"
class="{{ request('status')=='completed' ? 'active-filter' : '' }}">
Baigtos
</a>

</div>


<div class="filter-actions">

<form method="GET" class="admin-search">

<input
type="text"
name="search"
id="admin-search"
placeholder="Ieškoti istorijos arba autoriaus..."
value="{{ request('search') }}"
>

@if(request('status'))
<input type="hidden" name="status" value="{{ request('status') }}">
@endif

@if(request('sort'))
<input type="hidden" name="sort" value="{{ request('sort') }}">
@endif

</form>


<form method="GET" class="admin-sort">

@if(request('status'))
<input type="hidden" name="status" value="{{ request('status') }}">
@endif

@if(request('search'))
<input type="hidden" name="search" value="{{ request('search') }}">
@endif

<select name="sort" onchange="this.form.submit()">

<option value="created_desc"
{{ request('sort')=='created_desc' ? 'selected' : '' }}>
Naujausios
</option>

<option value="created_asc"
{{ request('sort')=='created_asc' ? 'selected' : '' }}>
Seniausios
</option>

</select>

</form>

</div>

</div>


<div id="stories-container">

@include('admin.partials.stories-list')

</div>

</div>

@endsection