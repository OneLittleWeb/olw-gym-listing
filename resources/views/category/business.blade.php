@extends('layouts.master')
@section('title', "$category->meta_title")
@if($city == null)
    @section('meta_description', "Explore the best $category->name in Nebraska. Get photos, business hours, phone numbers, ratings, reviews and service details.")
@else
    @section('meta_description', "Explore the best $category->name in " . Str::title($city->name) . ", Nebraska. Get photos, business hours, phone numbers, ratings, reviews and service details.")
@endif
@if($city != null)
    @section('meta_keywords', "$category->name in $city->name,ne , $category->name in $city->name near me")
@else
    @section('meta_keywords',  "$category->name in , ne")
@endif
@section('content')
    <section class="card-area section-padding">
        <div class="container pt-5">
            @if(count($organizations))
                <div class="row">
                    <div class="col-lg-12">
                        <div
                            class="breadcrumb-content breadcrumb-content-2 d-flex flex-wrap align-items-end justify-content-between margin-bottom-30px">
                            @if($city == null)
                                <ul class="list-items bread-list bread-list-2 bg-transparent rounded-0 p-0 text-capitalize">
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li>{{ $category->name }}</li>
                                </ul>
                            @else
                                <ul class="list-items bread-list bread-list-2 bg-transparent rounded-0 p-0 text-capitalize">
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li><a href="{{ route('category.index', $city->slug) }}">{{ $city->name }}</a></li>
                                    <li>{{ $category->name }}</li>
                                </ul>
                            @endif
                        </div>
                    </div><!-- end col-lg-12 -->
                    <div class="col-lg-12">
                        <div class="d-flex align-items-center pb-4 text-capitalize">
                            @if($city != null)
                                <h2 class="sec__title mb-0">{{ $business_category->organization_category }} in {{ $city->name }}, NE</h2>
                            @else
                                <h2 class="sec__title mb-0">{{ $business_category->organization_category }} in, NE</h2>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach($organizations as $organization)
                                <div class="col-lg-12">
                                    <div class="card-item card-item-list">
                                        <div class="card-image">
                                            <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}"
                                               class="d-block">
                                                @if($organization->organization_head_photo_file)
                                                    <img
                                                        src="{{ asset('images/business/' . $organization->organization_head_photo_file) }}"
                                                        data-src="{{ asset('images/business/' . $organization->organization_head_photo_file) }}"
                                                        class="card__img lazy"
                                                        alt="{{ $organization->organization_name }}">
                                                @else
                                                    <img src="{{ asset('images/default.jpg') }}"
                                                         data-src="{{ asset('images/default.jpg') }}"
                                                         class="card__img lazy"
                                                         alt="{{ $organization->organization_name }}">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="card-content">
                                            <h4 class="card-title">
                                                <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}">{{ $organization->organization_name }}</a>
                                            </h4>
                                            @if($organization->organization_address)
                                                <p class="card-sub">
                                                    <a href="#">
                                                        <i class="la la-map-marker mr-1 text-color-2"></i>{{ $organization->organization_address }}
                                                    </a>
                                                </p>
                                            @endif
                                            <ul class="listing-meta d-flex align-items-center">
                                                @if($organization->rate_stars && $organization->reviews_total_count)
                                                    <li class="d-flex align-items-center">
                                                        <span
                                                            class="rate flex-shrink-0">{{ $organization->rate_stars }}</span>
                                                        <span class="rate-text">{{ $organization->reviews_total_count }} Ratings</span>
                                                    </li>
                                                @endif
                                                <li>
                                                    <span class="price-range" data-toggle="tooltip" data-placement="top"
                                                          title="Pricey">
                                                        <strong class="font-weight-medium">$</strong>
                                                    </span>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <i class="{{ $organization->category->icon }}"></i>&nbsp;&nbsp;
                                                    <a href="{{ route('category.business', $organization->organization_category ? $organization->organization_category : $organization->category->name) }}"
                                                       class="listing-cat-link text-capitalize">{{ $organization->organization_category ? $organization->organization_category : $organization->category->name }}</a>
                                                </li>
                                            </ul>
                                            <ul class="info-list padding-top-20px">
                                                @if($organization->organization_website)
                                                    <li>
                                                        <span class="la la-link icon"></span>
                                                        <a rel="nofollow"
                                                           href="{{ 'https://' . $organization->organization_website }}"
                                                           target="_blank"> {{ $organization->organization_website }}</a>
                                                    </li>
                                                @endif
                                                @if($organization->organization_phone_number)
                                                    <li>
                                                        <span class="la la-phone icon"></span>
                                                        <a href="tel:{{ $organization->organization_phone_number }}">{{ $organization->organization_phone_number }}</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div><!-- end card-item -->
                                </div><!-- end col-lg-12 -->
                            @endforeach
                        </div><!-- end row -->
                        @if ($organizations->hasPages())
                            <div class="row">
                                <div class="col-lg-12 pt-3 text-center">
                                    <div class="pagination-wrapper d-inline-block">
                                        <div class="section-pagination">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination flex-wrap justify-content-center">
                                                    {{-- First Page Link --}}
                                                    @if ($organizations->onFirstPage())
                                                        <li class="page-item disabled" aria-disabled="true">
                                                            <a class="page-link page-link-first" href="#"
                                                               aria-hidden="true"><i
                                                                    class="la la-long-arrow-left mr-1"
                                                                    aria-hidden="true"></i> First</a>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link page-link-first"
                                                               href="{{ $organizations->url(1) }}" rel="first"><i
                                                                    class="la la-long-arrow-left mr-1"></i> First</a>
                                                        </li>
                                                    @endif
                                                    {{-- Previous Page Link --}}
                                                    @if ($organizations->onFirstPage())
                                                        <li class="page-item disabled" aria-disabled="true">
                                                            <a class="page-link" href="#" aria-label="Previous">
                                                            <span aria-hidden="true"><i
                                                                    class="la la-angle-left"></i></span>
                                                                <span class="sr-only" aria-hidden="true">Previous</span>
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                               href="{{ $organizations->previousPageUrl() }}"
                                                               aria-label="Previous" rel="prev">
                                                            <span aria-hidden="true"><i
                                                                    class="la la-angle-left"></i></span>
                                                                <span class="sr-only">Previous</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    {{-- Pagination Elements --}}
                                                    @foreach ($organizations->links()->elements as $element)
                                                        {{-- "Three Dots" Separator --}}
                                                        @if (is_string($element))
                                                            <li class="page-item disabled" aria-disabled="true"><span
                                                                    class="page-link">{{ $element }}</span></li>
                                                        @endif
                                                        {{-- Array Of Links --}}
                                                        @if (is_array($element))
                                                            @foreach ($element as $page => $url)
                                                                @if ($page == $organizations->currentPage())
                                                                    <li class="page-item active"
                                                                        aria-current="page"><span
                                                                            class="page-link">{{ $page }}</span></li>
                                                                @else
                                                                    <li class="page-item"><a class="page-link"
                                                                                             href="{{ $url }}">{{ $page }}</a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    {{-- Next Page Link --}}
                                                    @if ($organizations->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                               href="{{ $organizations->nextPageUrl() }}"
                                                               aria-label="Next" rel="next">
                                                        <span aria-hidden="true"><i
                                                                class="la la-angle-right"></i></span>
                                                                <span class="sr-only">Next</span>
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li class="page-item disabled" aria-disabled="true">
                                                        <span class="page-link" aria-hidden="true"><i
                                                                class="la la-angle-right"></i></span>
                                                            <span class="sr-only">Next</span>
                                                        </li>
                                                    @endif
                                                    {{-- Last Page Link --}}
                                                    @if ($organizations->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link page-link-last"
                                                               href="{{ $organizations->url($organizations->lastPage()) }}"
                                                               rel="last">Last <i
                                                                    class="la la-long-arrow-right ml-1"></i></a>
                                                        </li>
                                                    @else
                                                        <li class="page-item disabled" aria-disabled="true">
                                                            <a class="page-link page-link-last" href="#"
                                                               aria-hidden="true">Last
                                                                <i class="la la-long-arrow-right ml-1"
                                                                   aria-hidden="true"></i></a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </nav>
                                        </div><!-- end section-pagination -->
                                    </div>
                                </div><!-- end col-lg-12 -->
                            </div><!-- end row -->
                        @endif
                    </div><!-- end col-lg-8 -->
                    <div class="col-lg-4">
                        <div class="sidebar mb-0">
                            @if($cities)
                                <div class="sidebar-widget">
                                    <h3 class="widget-title">Filter by City</h3>
                                    <div class="stroke-shape mb-4"></div>
                                    <div class="category-list">
                                        @foreach($cities->take(6) as $f_city)
                                            <a href="{{ route('city.wise.organizations', ['city_slug' => $f_city->slug, 'category_slug' => $category->slug]) }}"
                                               class="generic-img-card d-block hover-y overflow-hidden mb-3">
                                                <img src="{{ asset('images/city/' . $f_city->background_image) }}"
                                                     data-src="{{ asset('images/city/' . $f_city->background_image) }}"
                                                     alt="image" class="generic-img-card-img filter-image lazy">
                                                <div
                                                    class="generic-img-card-content d-flex align-items-center justify-content-between">
                                                    <span class="badge text-capitalize">{{ $f_city->name }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                        <div class="collapse collapse-content" id="showMoreCity">
                                            @foreach($cities->skip(6) as $f_city)
                                                <a href="{{ route('city.wise.organizations', ['city_slug' => $f_city->slug, 'category_slug' => $category->slug]) }}"
                                                   class="generic-img-card d-block hover-y overflow-hidden mb-3">
                                                    <img src="{{ asset('images/city/' . $f_city->background_image) }}"
                                                         data-src="{{ asset('images/city/' . $f_city->background_image) }}"
                                                         alt="image" class="generic-img-card-img filter-image lazy">
                                                    <div
                                                        class="generic-img-card-content d-flex align-items-center justify-content-between">
                                                        <span class="badge text-capitalize">{{ $f_city->name }}</span>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                        <a class="collapse-btn" data-toggle="collapse" href="#showMoreCity"
                                           role="button" aria-expanded="false" aria-controls="showMoreCity">
                                            <span class="collapse-btn-hide">Show More <i
                                                    class="la la-plus ml-1"></i></span>
                                            <span class="collapse-btn-show">Show Less <i
                                                    class="la la-minus ml-1"></i></span>
                                        </a>
                                    </div>
                                </div><!-- end sidebar-widget -->
                            @endif

                            @if($city != null)
                                <div class="sidebar-widget">
                                    <h3 class="widget-title">Filter by Category</h3>
                                    <div class="stroke-shape mb-4"></div>
                                    <div class="category-list">
                                        @foreach($categories->take(5) as $category)
                                            <a href="{{ route('city.wise.organizations', ['city_slug' => $city->slug, 'category_slug' => $category->slug]) }}"
                                               class="generic-img-card d-block hover-y overflow-hidden mb-3">
                                                <img src="{{ asset('images/category/' . $category->background_image) }}"
                                                     data-src="{{ asset('images/category/' . $category->background_image) }}"
                                                     alt="image" class="generic-img-card-img filter-image lazy">
                                                <div
                                                    class="generic-img-card-content d-flex align-items-center justify-content-between">
                                                    <span class="badge text-capitalize">{{ $category->name }}</span>
                                                    <span
                                                        class="generic-img-card-counter">{{ $category->organizations->count() }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                        <div class="collapse collapse-content" id="showMoreCategory">
                                            @foreach($categories->skip(5) as $category)
                                                <a href="{{ route('city.wise.organizations', ['city_slug' => $city->slug, 'category_slug' => $category->slug]) }}"
                                                   class="generic-img-card d-block hover-y overflow-hidden mb-3">
                                                    <img
                                                        src="{{ asset('images/category/' . $category->background_image) }}"
                                                        data-src="{{ asset('images/category/' . $category->background_image) }}"
                                                        alt="image" class="generic-img-card-img filter-image lazy">
                                                    <div
                                                        class="generic-img-card-content d-flex align-items-center justify-content-between">
                                                        <span class="badge text-capitalize">{{ $category->name }}</span>
                                                        <span
                                                            class="generic-img-card-counter">{{ $category->organizations->count() }}</span>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                        <a class="collapse-btn" data-toggle="collapse" href="#showMoreCategory"
                                           role="button" aria-expanded="false" aria-controls="showMoreCategory">
                                            <span class="collapse-btn-hide">Show More <i
                                                    class="la la-plus ml-1"></i></span>
                                            <span class="collapse-btn-show">Show Less <i
                                                    class="la la-minus ml-1"></i></span>
                                        </a>
                                    </div>
                                </div><!-- end sidebar-widget -->
                            @endif
                        </div><!-- end sidebar -->
                    </div><!-- end col-lg-4 -->
                </div><!-- end row -->
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div
                            class="filter-bar d-flex flex-wrap margin-bottom-30px">
                            <p class="result-text font-weight-medium">No Business Found</p>
                        </div><!-- end filter-bar -->
                    </div><!-- end col-lg-12 -->
                </div>
            @endif
        </div><!-- end container -->
    </section><!-- end card-area -->
@endsection
