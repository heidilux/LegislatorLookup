<hr class="col-xs-12">
<div class="row">
    @if (empty($legi))
        <div class="col-sm-6 col-sm-offset-3">
            <div class="alert alert-warning text-center">Whoops! We didn't find any search results for that query.</div>
        </div>
    @endif
</div>

@if (!empty($legi))
    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <div id="party-chart"></div>
        </div>
    </div>

    <div class="row">
        @foreach($legi as $leg)

            <div class="col-sm-6 col-lg-4">
                <div class="thumbnail {!! ($leg['party'] == 'R') ? 'repub' : 'democrat' !!}">
                    <a href="{!! route('legislator', [$leg['bioguide_id']]) !!}">
                        <img class="img-rounded" src="https://theunitedstates.io/images/congress/225x275/{!! $leg['bioguide_id'] !!}.jpg"
                             alt="{!! $leg['last_name'] !!}">
                    </a>
                    <div class="caption">
                        <h4 class="text-center">
                            {!! ($leg['chamber'] == 'house') ? 'Representative ' : 'Senator ' !!}
                        </h4>
                        <h3 class="text-center">
                            {!! ($leg['nickname']) ?:
                            $leg['first_name'] !!} {!! $leg['last_name'] !!}
                            <small> - {!! $leg['state_name'] !!} ({!! $leg['party'] !!})</small>
                        </h3>
                        <div class="list-group">
                            <a href="{!! $leg['website'] !!}" target="_blank" class="list-group-item">Visit Website</a>
                            <a href="{!! route('sponsored-bills', [$leg['bioguide_id']]) !!}" class="list-group-item">View Bills</a>
                            <a href="{!! route('committees', [$leg['bioguide_id']]) !!}" class="list-group-item">Committees</a>
                            <div class="list-group-item text-center">
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
            </div>
        @endforeach
    </div>
@endif
