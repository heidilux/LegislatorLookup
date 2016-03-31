<hr class="col-xs-12">
<div class="row">
    <div class="col-sm-4">
        <div class="thumbnail {!! ($leg['party'] == 'R') ? 'repub' : 'democrat' !!}">
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
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel {!! ($leg['party'] == 'R') ? 'panel-danger' : 'panel-info' !!}">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Vitals
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <i class="fa fa-fw fa-birthday-cake"></i> {{ $leg['birthday'] }}
                            </li>
                            <li class="list-group-item">
                                <h5 class="list-group-item-heading">Term</h5>
                                <i class="fa fa-fw fa-hourglass-start"></i> {{ $leg['term_start'] }}<br>
                                <i class="fa fa-fw fa-hourglass-end"></i> {{ $leg['term_end'] }}
                            </li>
                            <li class="list-group-item">
                                @if ($leg['district'] != '0th' && $leg['district'] != 'th')
                                    {{ $leg['state_name']  }}'s {{ $leg['district'] }} District
                                @elseif ($leg['chamber'] == 'senate')
                                    {{ ucwords($leg['state_rank']) }} Senator from {{ $leg['state_name'] }}
                                @else
                                    {{ $leg['state_name'] }} Representative
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel {!! ($leg['party'] == 'R') ? 'panel-danger' : 'panel-info' !!}">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Contact Information
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <i class="fa fa-fw fa-building"></i> {{ $leg['office'] }}
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-fw fa-envelope"></i>
                                <a href="mailto:{{ $leg['oc_email'] }}">{{ $leg['oc_email'] }}</a>
                            </li>
                            <li class="list-group-item">
                                {!! ($leg['phone'] != '') ? '<i class="fa fa-fw fa-phone"></i> ' . $leg['phone'] : '' !!}
                                {!! ($leg['fax'] != '') ? '<br><i class="fa fa-fw fa-fax"></i> ' . $leg['fax'] : '' !!}
                            </li>

                            @if ($leg['website'] != '')
                            <li class="list-group-item">
                                Website: <a href="{!! $leg['website'] !!}" target="_blank">{{ $leg['website'] }}</a>
                            </li>
                            @endif

                            @if ($leg['contact_form'] != '')
                            <li class="list-group-item">
                                Contact Form: <a href="{{ $leg['contact_form'] }}" target="_blank">{{ $leg['contact_form'] }}</a>
                            </li>
                            @endif

                            <li class="list-group-item">
                                Social Media:
                                @if (!array_key_exists('twitter_id', $leg) &&
                                      array_key_exists('youtube_id', $leg) &&
                                      array_key_exists('facebook_id', $leg))
                                    (no information)
                                @endif
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
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel {!! ($leg['party'] == 'R') ? 'panel-danger' : 'panel-info' !!}">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Activity
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        Coming soon...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
