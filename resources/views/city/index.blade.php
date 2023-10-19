@extends('layouts.master')
@section('title', config('app.name') . " THE Local Business Directory | Cities")
@section('meta_description', "Browse all the cities in the USA to find the best local service you’re looking for. Professional gyms - all in one place.")
@section('meta_keywords',"USA, gymnearx, best places in the USA")
@section('content')
    <section class="category-area section--padding margin-top-40px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div
                        class="breadcrumb-content breadcrumb-content-2 d-flex flex-wrap align-items-end justify-content-between margin-bottom-20px">
                        <div class="section-heading">
                            <ul class="list-items bread-list bread-list-2 bg-transparent rounded-0 p-0 text-capitalize">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li>
                                    Cities
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-md-flex flex-row justify-content-between pb-4 text-capitalize">
                        <div>
                            <h1 class="sec__title mb-0">Popular Cities in the USA</h1>
                            <div class="stroke-shape mb-4 mb-md-0"></div>
                        </div>
                        <div>
                            <input type="text" class="form-control p-2 mt-2 mt-md-0" id="all_state_search"
                                   name="all_state_search"
                                   placeholder="Search City" autocomplete="off">
                        </div>
                    </div>

                    <div id="no_results_message" style="display: none">No City Result Found</div>
                </div>
            </div>
            @if(count($cities))
                <div class="row organization-state-list">
                    @foreach($cities as $city)
                        <div class="col-lg-3 responsive-column">
                            <div class="category-item overflow-hidden">
                                <img src="{{ asset('images/gym-state.jpg') }}"
                                     data-src="{{ asset('images/gym-state.jpg') }}"
                                     alt="{{ $city->name }}" class="cat-img lazy">
                                <div class="category-content d-flex align-items-center justify-content-center">
                                    <a href="{{ route('city.wise.organizations', ['state_slug' => $city->state->slug, 'city_slug' => $city->slug]) }}"
                                       class="category-link d-flex flex-column justify-content-center w-100 h-100">
                                        <div class="cat-content">
                                            <h4 class="cat__title mb-3">{{ $city->name }}</h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div
                            class="filter-bar d-flex flex-wrap margin-bottom-30px">
                            <p class="result-text font-weight-medium">No City Found</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
