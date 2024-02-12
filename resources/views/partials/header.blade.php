<header class="{{ Route::currentRouteName() == 'home' ? 'main-header-area' : 'header-area' }}">
    <div class="header-menu-wrapper padding-right-30px padding-left-30px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="menu-full-width">
                        <div class="logo">
                            <a href="{{ route('home') }}"><img src="{{asset('/images/logo-white.png')}}" alt="logo"></a>
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

                        @if(Route::currentRouteName() != 'home' && Route::currentRouteName() != 'gym.near.me')
                            <form action="{{ route('search') }}"
                                  class="main-search-input-item quick-search-form form-box d-flex align-items-center">
                                @csrf
                                <div class="form-group mb-0">
                                    <input class="form-control rounded-0 looking-for search-from-header" type="search"
                                           id="search_from_header"
                                           name="looking_for" placeholder="What are you looking for?" autocomplete="off"
                                           required>
                                </div>
                                <input type="hidden" name="source_value" id="source_value">
                                <input type="hidden" name="source_id" id="source_id">
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
                                        <a href="{{ route('home') }}">home</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('gym.near.me', ['category_slug' => 'gym', 'suffix' => 'near-me']) }}">Gyms
                                            Near Me</a>
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
