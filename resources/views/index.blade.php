@extends('app')

@section('content')

<h1 class="text-center">Lookup your legislators</h1>

<div class="col-md-4 col-md-offset-4">
    <div class="well">
        <form class="form-inline">
            <div class="form-group">
                <label class="sr-only" for="zip">Zip Code</label>
                <input type="text" class="form-control" id="zip" placeholder="Search by zip code">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
</div>
<hr class="col-xs-12">
<div class="row">
    @foreach($legi as $leg)

        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="https://theunitedstates.io/images/congress/225x275/{!! $leg['bioguide_id'] !!}.jpg" alt="{!! $leg['last_name'] !!}">
                <div class="caption">
                    <h4 class="text-center">
                        {!! ($leg['chamber'] == 'house') ? 'Representative ' : 'Senator ' !!}
                    </h4>
                    <h3 class="text-center">
                        {!! ($leg['nickname']) ?:
                        $leg['first_name'] !!} {!! $leg['last_name'] !!}
                        <small> - {!! $leg['state_name'] !!} ({!! $leg['party'] !!})</small>
                    </h3>
                </div>
            </div>
        </div>
    @endforeach
</div>





@endsection