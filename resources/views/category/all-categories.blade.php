@extends('layouts.master')
@section('title', "Nebraskalisting THE Local Business Directory | Categories")
@section('meta_description', "Explore variety services and businesses like salons, gym, restaurant, hotels, car wash, pest control, moving companies, dentists and so on in Nebraska.")
@section('meta_keywords',"nebraska, nebraskalisting, best places in nebraska")
@section('content')
    <section class="category-area section--padding margin-top-40px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content breadcrumb-content-2 d-flex flex-wrap align-items-end justify-content-between margin-bottom-20px">
                        <div class="section-heading">
                            <ul class="list-items bread-list bread-list-2 bg-transparent rounded-0 p-0 text-capitalize">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li>
                                    Categories
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex align-items-center pb-4 text-capitalize">
                        <h1 class="sec__title mb-0">Popular Categories</h1>
                    </div>
                </div>
            </div>
            @if(count($categories))
                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-lg-3 responsive-column">
                            <div class="category-item overflow-hidden">
                                <img src="{{asset('images/category/' . $category->background_image)}}"
                                     data-src="{{asset('images/category/' . $category->background_image)}}"
                                     alt="{{ $category->name }}" class="cat-img lazy">
                                <div class="category-content d-flex align-items-center justify-content-center">
                                    <a href="{{ route('category.index', $category->slug) }}"
                                       class="category-link d-flex flex-column justify-content-center w-100 h-100">
                                        <div class="icon-element mb-3 mx-auto">
                                            <span class="{{ $category->icon }}"></span>
                                        </div>
                                        <div class="cat-content">
                                            <h4 class="cat__title mb-3">{{ $category->name }}</h4>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- end category-item -->
                        </div><!-- end col-lg-3 -->
                    @endforeach
                </div><!-- end row -->
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div
                            class="filter-bar d-flex flex-wrap margin-bottom-30px">
                            <p class="result-text font-weight-medium">No Category Found</p>
                        </div><!-- end filter-bar -->
                    </div><!-- end col-lg-12 -->
                </div>
            @endif
        </div><!-- end container -->
    </section>
@endsection
