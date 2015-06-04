@extends('app')

@section('content')

<h1>{!! ($legislator[0]['nickname']) ?: $legislator[0]['first_name'] !!} {!! $legislator[0]['last_name'] !!}
    <small> - {!! $legislator[0]['state_name'] !!} ({!! $legislator[0]['party'] !!})</small>
</h1>

    <table class="table">
        <thead>
        <tr>
            <th>{!! ucfirst($legislator[0]['chamber']) !!} Bill #</th>
            <th>Title</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($bills as $bill)
            <tr>
                <td><a href="{!! $bill['last_version']['urls']['html'] !!}">{!! $bill['number'] !!}</a> </td>
                <td>{!! $bill['official_title'] !!}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection