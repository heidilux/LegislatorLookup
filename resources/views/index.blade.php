@extends('app')

@section('content')

<h1 class="text-center">Lookup your legislators</h1>

@include('partials.search-form')


@if (isset($legi))
    @include('partials.legislator')
@endif

@if (isset($committees))
    @include('partials.committees')
@endif


@endsection

@section('scripts')
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
    <script src="/js/search.js"></script>
@endsection