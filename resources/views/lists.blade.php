@extends('app')

@section('content')

<h1>{!! ($legislator['nickname']) ?: $legislator['first_name'] !!} {!! $legislator['last_name'] !!}
    <small> - {!! $legislator['state_name'] !!} ({!! $legislator['party'] !!})</small>
</h1>
    @if(isset($bills))
        <table class="table">
            <thead>
            <tr>
                <th>{!! ucfirst($legislator['chamber']) !!} Bill #</th>
                <th>Title</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($bills as $bill)
                    <tr>
                        <td>
                            @if (isset($bill['last_version']['urls']['html']))
                                <a href="{!! $bill['last_version']['urls']['html'] !!}">{!! $bill['number'] !!}</a>
                            @else {!! $bill['number'] !!}
                            @endif
                        </td>
                        <td>{!! $bill['official_title'] !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(isset($committees))
        <table class="table">
            <thead>
            <tr>
                <th>{!! ucfirst($legislator['chamber']) !!} Committees</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($committees as $committee)
                    <tr>
                        <td>
                            <li>{!! $committee['name'] !!}</li>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


@endsection