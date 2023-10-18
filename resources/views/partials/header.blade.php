<header class="{{ Route::currentRouteName() == 'home' ? 'main-header-area' : 'header-area' }}">
    <div class="header-menu-wrapper padding-right-30px padding-left-30px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="menu-full-width">
                        <div class="logo">
                            <a href="/"><img src="{{asset('/images/logo-white.png')}}" alt="logo"></a>
                            <div class="d-flex align-items-center">
                                <a href="#"
                                   class="btn-gray add-listing-btn-show font-size-24 mr-2 flex-shrink-0"
                                   data-toggle="tooltip" data-placement="left" title="Add Listing">
                                    <i class="la la-plus"></i>
                                </a>
                                <div class="menu-toggle">
                                    <span class="menu__bar"></span>
                                    <span class="menu__bar"></span>
                                    <span class="menu__bar"></span>
                                </div>
                            </div>
                        </div>

                        @if(Route::currentRouteName() != 'home')
                            <form action="{{ route('search') }}"
                                  class="main-search-input-item quick-search-form form-box d-flex align-items-center">
                                @csrf
                                <div class="form-group mb-0">
                                    <input class="form-control rounded-0 looking-for" type="search"
                                           id="search-from-header"
                                           name="looking_for" placeholder="What are you looking for?" autocomplete="off"
                                           required>
                                </div>
                                <input type="hidden" name="source_value" id="source_value">
                                <input type="hidden" name="source_id" id="source_id">

                                <!-- Autocomplete results div -->
                                <div id="autocomplete-results"></div>
                                <div>
                                    <button type="submit" class="btn btn-warning header-search-button rounded-0">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>

                            </form>
                        @endif

                        <div class="main-menu-content ml-auto">
                            <nav class="main-menu">
                                <ul>
                                    <li>
                                        <a href="/">home</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('states.index') }}">states</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('city.index') }}">cities</a>
                                    </li>
                                    <li>
                                        <a href="/blog">blog</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="nav-right-content">
                            <a href="{{ route('login') }}"
                               class="theme-btn gradient-btn shadow-none add-listing-btn-hide">
                                <i class="la la-plus mr-2"></i> Add Listing
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@section('js')
{{--    <script--}}
{{--        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>--}}
    <script>
        {{--let path = "{{ route('autocomplete')}}";--}}
        {{--$('#search-from-header').typeahead({--}}
        {{--    source: function (query, process) {--}}
        {{--        return $.get(path, {term: query}, function (data) {--}}
        {{--            return process(data);--}}
        {{--        });--}}
        {{--    },--}}
        {{--    updater: function (item) {--}}
        {{--        let id = item.id;--}}
        {{--        let name = item.source;--}}
        {{--        $('#source_value').val(name);--}}
        {{--        $('#source_id').val(id);--}}
        {{--        return item.name;--}}
        {{--    }--}}
        {{--});--}}

        $(document).ready(function () {
            let path = "{{ route('autocomplete')}}";
            let input = $('#search-from-header');
            let sourceValue = $('#source_value');
            let sourceId = $('#source_id');
            let resultsDiv = $('#autocomplete-results');

            input.on('input', function () {
                let query = input.val();

                $.get(path, { term: query }, function (data) {
                    resultsDiv.empty();

                    if (data.length > 0) {
                        data.forEach(function (item) {
                            let listItem = $('<div class="autocomplete-item">' + item.name + '</div>');

                            listItem.on('click', function () {
                                let id = item.id;
                                let name = item.source;

                                sourceValue.val(name);
                                sourceId.val(id);
                                input.val(item.name);
                                resultsDiv.empty();
                            });

                            resultsDiv.append(listItem);
                        });
                    }
                });
            });

            // Handle click outside to close results
            $(document).on('click', function (e) {
                if (!input.is(e.target) && input.has(e.target).length === 0) {
                    resultsDiv.empty();
                }
            });
        });
    </script>
@endsection
