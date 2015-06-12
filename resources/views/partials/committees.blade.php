<ul>
    @foreach($committees as $committee)
        <li>{!! $committee['name'] !!}</li>
    @endforeach
</ul>