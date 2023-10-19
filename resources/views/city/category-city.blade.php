@extends('layouts.master')
@section('title', "Nebraskalisting THE Local Business Directory | " . Str::title($category->name))
@section('meta_description', "Find the best $category->name in cities around Nebraska. Get photos, business hours, phone numbers, ratings, reviews and service details.")
@section('meta_keywords',"nebraska, nebraskalisting, best places in nebraska")
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
                                <li>{{ $category->name }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex align-items-center pb-4 text-capitalize">
                        <h1 class="sec__title mb-0">Popular Cities in Nebraska</h1>
                    </div>
                </div>
            </div>
            @if(count($cities))
                <div class="row">
                    @foreach($cities as $city)
                        <div class="col-lg-3 responsive-column">
                            <div class="category-item overflow-hidden">
                                <img src="{{ asset('images/city/' . $city->background_image) }}"
                                     data-src="{{ asset('images/city/' . $city->background_image) }}"
                                     alt="{{ $city->name }}" class="cat-img lazy">
                                <div class="category-content d-flex align-items-center justify-content-center">
                                    <a href="#"
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
