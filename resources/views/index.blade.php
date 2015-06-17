@extends('app')

@section('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection

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
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="/js/partyChart.js"></script>
@endsection