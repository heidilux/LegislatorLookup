<hr class="col-xs-12">
<div class="row">
    <div class="col-sm-4">
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
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
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
                                Born: {{ $leg['birthday'] }}
                            </li>
                            <li class="list-group-item">
                                Term: {{ $leg['term_start'] }} - {{ $leg['term_end'] }}
                            </li>
                            <li class="list-group-item">
                                {{ $leg['state_name']  }}'s {{ $leg['district'] }}
                                District
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
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
                                Website: <a href="{!! $leg['website'] !!}" target="_blank">{{ $leg['website'] }}</a>
                            </li>
                            <li class="list-group-item">
                                Contact Form: <a href="{!! $leg['contact_form'] !!}" target="_blank">{{ $leg['contact_form'] }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Activity
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        More stuff
                    </div>
                </div>
            </div>
        </div>
        <ul>
            @foreach ($leg as $label => $data)
                <li>{{ $label }}: {{ $data }}</li>
            @endforeach
        </ul>

    </div>

</div>
