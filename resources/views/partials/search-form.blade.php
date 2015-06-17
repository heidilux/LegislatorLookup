<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
    <form id="query-form">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" id="filter" name="filter" value="name">

        <div class="input-group {!! ($errors->has('zip')) ? 'has-error' : '' !!}">
            <input required type="text" id="search-query" class="form-control" name="query"
                   value="{!! old('query') !!}" placeholder="Search by" autofocus />
            <div class="input-group-btn">
                <a href="#" id="search-btn" class="btn btn-default">Name</a>
                <button id="search-dropdown" type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown">&nbsp;<span class="caret"></span>&nbsp;</button>
                <ul id="search-filter" class="dropdown-menu dropdown-menu-right" role="menu">
                    <li><a href="#" data-method="legislators" data-filter="query">Name</a></li>
                    <li><a href="#" data-method="locate" data-filter="zip">Zipcode</a></li>
                    <li><a href="#" data-method="legislators" data-filter="state">State</a></li>
                </ul>
            </div>
        </div>
        @if ($errors->has('zip')) <p class="help-block">{!! $errors->first('zip') !!}</p> @endif
    </form>

</div>