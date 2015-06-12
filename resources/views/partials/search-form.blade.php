<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
    <form id="query-form">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" id="filter" name="filter" value="name">
        <div class="form-inline">
            <div class="form-group {!! ($errors->has('zip')) ? 'has-error' : '' !!}">
                <input required type="text" id="search-query" class="form-control" name="query"
                       value="{!! old('query') !!}" placeholder="Search by" autofocus />
            </div>
            <div class="form-group">
                <div class="btn-group">
                    <a href="#" id="search-btn" class="btn btn-default">Name</a>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
                    <ul id="search-filter" class="dropdown-menu dropdown-menu-right" role="menu">
                        <li><a href="#" data-method="legislators" data-filter="query">Name</a></li>
                        <li><a href="#" data-method="locate" data-filter="zip">Zipcode</a></li>
                        <li><a href="#" data-method="legislators" data-filter="state">State (ABBV)</a></li>
                    </ul>
                </div>
                {{--<input type="text" class="form-control" name="zip" placeholder="Search by zip code" value="{!! old('zip') !!}" autofocus>--}}
                @if ($errors->has('zip')) <p class="help-block">{!! $errors->first('zip') !!}</p> @endif
            </div>
        </div>
    </form>

</div>