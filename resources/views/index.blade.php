@extends('app')

@section('content')

<h1 class="text-center">Lookup your legislators</h1>

<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
    <form action="{!! route('ziplookup') !!}" method="post">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="form-group {!! ($errors->has('zip')) ? 'has-error' : '' !!}">
            <label class="sr-only" for="zip">Zip Code</label>
            <input type="text" class="form-control" name="zip" placeholder="Search by zip code" value="{!! old('zip') !!}" autofocus>
            @if ($errors->has('zip')) <p class="help-block">{!! $errors->first('zip') !!}</p> @endif
        </div>
        <button type="submit" class="btn btn-primary btn-block">Search</button>
    </form>
</div>
@if (isset($legi))

    <hr class="col-xs-12">

    <div class="row">
        @if (empty($legi))
            <div class="col-sm-6 col-sm-offset-3">
                <div class="alert alert-warning">Whoops! Either that's not a valid zip code, or there is no federal representation!!</div>
            </div>
        @endif


        @foreach($legi as $leg)

            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img class="img-rounded" src="https://theunitedstates.io/images/congress/225x275/{!! $leg['bioguide_id'] !!}.jpg"
                         alt="{!! $leg['last_name'] !!}">
                    <div class="caption">
                        <h4 class="text-center">
                            {!! ($leg['chamber'] == 'house') ? 'Representative ' : 'Senator ' !!}
                        </h4>
                        <h3 class="text-center">
                            {!! ($leg['nickname']) ?:
                            $leg['first_name'] !!} {!! $leg['last_name'] !!}
                            <small> - {!! $leg['state_name'] !!} ({!! $leg['party'] !!})</small>
                        </h3>
                        {{--<ul class="list-group">--}}
                            {{--<li class="list-group-item">{!! $leg['phone'] !!}</li>--}}
                            {{--<li class="list-group-item"><a href="{!! $leg['contact_form'] !!}">Contact Form</a></li>--}}
                            {{--<li class="list-group-item">{!! $leg['office'] !!}</li>--}}
                        {{--</ul>--}}
                        <div class="button-row clearfix">
                            <div class="pull-left">
                                <a href="{!! $leg['website'] !!}" target="_blank">
                                    <button class="btn btn-success">Visit website</button>
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="{!! route('sponsored-bills', [$leg['bioguide_id']]) !!}">
                                    <button class="btn btn-primary">View Bills</button>
                                </a>
                            </div>
                        </div>


                        <div class="text-center">
                            @if (array_key_exists('twitter_id', $leg))
                                <a href="http://twitter.com/{!! $leg['twitter_id'] !!}" target="_blank">
                                    <i class="fa fa-2x fa-twitter-square"></i> </a>
                            @endif
                            @if (array_key_exists('youtube_id', $leg))
                                <a href="http://youtube.com/{!! $leg['youtube_id'] !!}" target="_blank">
                                    <i class="fa fa-2x fa-youtube-square"></i> </a>
                            @endif
                            @if (array_key_exists('facebook_id', $leg))
                                <a href="http://facebook.com/{!! $leg['facebook_id'] !!}" target="_blank">
                                    <i class="fa fa-2x fa-facebook-square"></i> </a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif





@endsection