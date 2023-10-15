@extends('layouts.master')
@section('title', "$state->meta_title")
@if (count($organizations) && $organizations->currentPage() > 1)
    @section('meta')
        <meta name="robots" content="noindex, follow">
    @endsection
@endif
@section('meta_description', "Explore the best $state->name in " . Str::title($city->name) . ", Nebraska. Get photos, business hours, phone numbers, ratings, reviews and service details.")
@section('meta_keywords', "$state->name in $city->name,ne , $state->name in $city->name near me")
@section('content')
    <section class="card-area section-padding">
        <div class="container pt-5">
            @if(count($organizations))
                <div class="row">
                    <div class="col-lg-12">
                        <div
                            class="breadcrumb-content breadcrumb-content-2 d-flex flex-wrap align-items-end justify-content-between margin-bottom-30px">
                            <ul class="list-items bread-list bread-list-2 bg-transparent rounded-0 p-0 text-capitalize">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('category.index', $city->slug) }}">{{ $city->name }}</a></li>
                                <li>{{ $state->name }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="d-flex align-items-center pb-4 text-capitalize">
                            <h1 class="sec__title mb-0">Top 10 Best Gym near {{ $city->name }},
                                {{ $state->name }}</h1>
                        </div>
                    </div>
                    @if($organizations->onFirstPage() && $organization_badge)
                        <div class="col-lg-12 nebraska-badge-div mobile">
                            <img class="nebraska-badge-image" src="{{ asset('images/badges/' . $organization_badge) }}"
                                 data-src="{{ asset('images/badges/' . $organization_badge) }}" alt="Nebraska Badge">
                            <p class="text-justify">We considered
                                all {{ $organization_count }} {{ $organizations[0]->category->name }} Companies in the
                                {{ $organizations[0]->city->name }} area. We looked at
                                all the data and analyzed these companies on costs, customer rating,
                                reliability,
                                and experience to identify the top 10.</p>
                        </div>
                    @endif
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
                                                        alt="{{ $organization->organization_name }}" loading="lazy">
                                                @else
                                                    <img src="{{ asset('images/default.jpg') }}"
                                                         data-src="{{ asset('images/default.jpg') }}"
                                                         class="card__img lazy"
                                                         alt="{{ $organization->organization_name }}" loading="lazy">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="card-content">
                                            <h2 class="card-title">
                                                <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}">{{ $organization->organization_name }}</a>
                                            </h2>
                                            <p class="card-sub">
                                                <a href="#">
                                                    <i class="la la-map-marker mr-1 text-color-2"></i>
                                                    @if($organization->organization_address)
                                                        {{ str_replace('Address: ', '', $organization->organization_address) }}
                                                    @else
                                                        {{ ucfirst($organization->city->name) }}, Nebraska, US
                                                    @endif
                                                </a>
                                            </p>
                                            <ul class="listing-meta d-flex align-items-center">
                                                @if($organization->rate_stars && $organization->reviews_total_count)
                                                    <li class="d-flex align-items-center">
                                                        <span
                                                            class="rate flex-shrink-0">{{ $organization->rate_stars }}</span>
                                                        <span class="rate-text">{{ $organization->reviews_total_count }} Reviews</span>
                                                    </li>
                                                @endif
                                                <li>
                                                    <span class="price-range" data-toggle="tooltip" data-placement="top"
                                                          title="Pricey">
                                                        <strong class="font-weight-medium">{{ $organization->price_policy ?? '$' }}</strong>
                                                    </span>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <i class="{{ $organization->category->icon }}"></i>&nbsp;&nbsp;
                                                    <a href="{{ route('category.business', $organization->organization_category ? $organization->organization_category : $organization->category->slug) }}"
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
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="sidebar mb-0">
                            @if($organizations->onFirstPage() && $organization_badge)
                                <div class="nebraska-badge-div desktop">
                                    <img class="nebraska-badge-image"
                                         src="{{ asset('images/badges/' . $organization_badge) }}"
                                         data-src="{{ asset('images/badges/' . $organization_badge) }}"
                                         alt="Nebraska Badge">
                                    <p class="text-justify">We considered
                                        all {{ $organization_count }} {{ $organizations[0]->category->name }} Companies
                                        in the
                                        {{ $organizations[0]->city->name }} area. We looked at
                                        all the data and analyzed these companies on costs, customer rating,
                                        reliability,
                                        and experience to identify the top 10.</p>
                                </div>
                            @endif

                            @if($cities)
                                <div class="sidebar-widget">
                                    <h3 class="widget-title">Filter by City</h3>
                                    <div class="stroke-shape mb-4"></div>
                                    <div class="category-list">
                                        @foreach($cities->take(6) as $f_city)
                                            <a href="{{ route('city.wise.organizations', ['city_slug' => $f_city->slug, 'state_slug' => $state->slug]) }}"
                                               class="generic-img-card d-block hover-y overflow-hidden mb-3">
                                                <img src="{{ asset('images/cta-sm.jpg') }}"
                                                     data-src="{{ asset('images/cta-sm.jpg') }}"
                                                     alt="image" class="generic-img-card-img filter-image lazy"
                                                     loading="lazy">
                                                <div
                                                    class="generic-img-card-content d-flex align-items-center justify-content-between">
                                                    <span class="badge text-capitalize">{{ $f_city->name }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                        <div class="collapse collapse-content" id="showMoreCity">
                                            @foreach($cities->skip(6) as $f_city)
                                                <a href="{{ route('city.wise.organizations', ['city_slug' => $f_city->slug, 'state_slug' => $state->slug]) }}"
                                                   class="generic-img-card d-block hover-y overflow-hidden mb-3">
                                                    <img src="{{ asset('images/cta-sm.jpg') }}"
                                                         data-src="{{ asset('images/cta-sm.jpg') }}"
                                                         alt="image" class="generic-img-card-img filter-image lazy"
                                                         loading="lazy">
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
                                </div>
                            @endif
                            @if($city != null)
                                <div class="sidebar-widget">
                                    <h3 class="widget-title">Filter by Category</h3>
                                    <div class="stroke-shape mb-4"></div>
                                    <div class="category-list">
                                        @foreach($states->take(5) as $state)
                                            <a href="{{ route('city.wise.organizations', ['city_slug' => $city->slug, 'state_slug' => $state->slug]) }}"
                                               class="generic-img-card d-block hover-y overflow-hidden mb-3">
                                                <img src="{{ asset('images/sm-bg.jpg') }}"
                                                     data-src="{{ asset('images/sm-bg.jpg') }}"
                                                     alt="image" class="generic-img-card-img filter-image lazy"
                                                     loading="lazy">
                                                <div
                                                    class="generic-img-card-content d-flex align-items-center justify-content-between">
                                                    <span class="badge text-capitalize">{{ $state->name }}</span>
                                                    <span
                                                        class="generic-img-card-counter">{{ $state->organizations->count() }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                        <div class="collapse collapse-content" id="showMoreCategory">
                                            @foreach($states->skip(5) as $state)
                                                <a href="{{ route('city.wise.organizations', ['city_slug' => $city->slug, 'state_slug' => $state->slug]) }}"
                                                   class="generic-img-card d-block hover-y overflow-hidden mb-3">
                                                    <img
                                                        src="{{ asset('images/sm-bg.jpg') }}"
                                                        data-src="{{ asset('images/sm-bg.jpg') }}"
                                                        alt="image" class="generic-img-card-img filter-image lazy"
                                                        loading="lazy">
                                                    <div
                                                        class="generic-img-card-content d-flex align-items-center justify-content-between">
                                                        <span class="badge text-capitalize">{{ $state->name }}</span>
                                                        <span
                                                            class="generic-img-card-counter">{{ $state->organizations->count() }}</span>
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
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div
                            class="filter-bar d-flex flex-wrap margin-bottom-30px">
                            <p class="result-text font-weight-medium">No Business Found</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
