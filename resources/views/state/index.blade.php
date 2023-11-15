@extends('layouts.master')
@section('title', config('app.name') . " THE Local Business Directory | States")
@section('meta_description', "Browse all the states in the USA to find the best local service you’re looking for. Professional gyms - all in one place.")
@section('meta_keywords',"USA, gymnearx, best gym in the USA")
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
                                    States
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-md-flex flex-row justify-content-between pb-4 text-capitalize">
                        <div>
                            <h1 class="sec__title mb-0">All States in the USA</h1>

                            <div class="stroke-shape mb-4 mb-md-0"></div>
                        </div>
                        <div>
                            <input type="text" class="form-control p-2 mt-2 mt-md-0" id="all_state_search"
                                   name="all_state_search"
                                   placeholder="Search State" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            @if(count($states))
                <div class="row organization-state-list">
                    <div class="col-lg-12">
                        <div class="listing-detail-wrap">
                            @foreach($states as $state)
                                <div class="single-state-block-card-div" data-target="{{ $state->slug }}">
                                    <div class="state-block-card mb-4">
                                        <div class="all-state-container">
                                            <div class="d-flex justify-content-between single-state-block-card">
                                                <a class="text-capitalize all-state-widget-title"
                                                   href="{{ route('category.wise.business',['state_slug' => $state->slug , 'organization_category_slug' => 'gym']) }}">
                                                    <img src="{{asset('images/state/' . $state->background_image)}}"
                                                         data-src="{{asset('images/state/' . $state->background_image)}}"
                                                         alt="country-image"
                                                         class="lazy state-icon-element states-flag">
                                                    <span class="pl-2">{{ $state->name }}</span>
                                                </a>
                                                <div class="toggle-icon">
                                                    <i class="fa-solid fa-caret-down"></i>
                                                </div>
                                            </div>
                                            <div class="all-state-info-list-box" id="{{ $state->slug }}">
                                                <ul class="row info-list pl-1">
                                                    @foreach($state->cities as $city)
                                                        <li class="col-lg-3 city-state-title">
                                                            <a href="{{ route('city.wise.organizations', ['state_slug' => $city->state->slug, 'city_slug' => $city->slug]) }}">{{ $city->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 no-state-found-message" style="display: none;">
                        <div class="filter-bar d-flex flex-wrap">
                            <p class="result-text font-weight-medium">No State Found</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div
                            class="filter-bar d-flex flex-wrap margin-bottom-30px">
                            <p class="result-text font-weight-medium">No State Found</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
