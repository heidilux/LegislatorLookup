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




@endsection