@extends('layouts.master')
@section('title', str_replace("'","",$organization->meta_title))
@if ($organization->reviews_paginator->currentPage() > 1)
    @section('meta')
        <meta name="robots" content="noindex, follow">
    @endsection
@endif
@section('meta_description', str_replace("'","",$organization->organization_name) . " is in $city->name. Get photos, business hours, phone numbers, ratings, reviews and service details. Rate and review.")
@section('meta_keywords',  str_replace("'","",$organization->organization_name). ", " .str_replace("'","",$organization->organization_name) . " review")
@section('content')
    <!-- ======START FULL SCREEN SLIDER===== -->
    <section class="full-screen-slider-area slide-image-top">
        @if($organization->organization_photos_files)
            <div class="full-screen-slider owl-trigger-action owl-trigger-action-2">
                @foreach(explode(',', $organization->organization_photos_files) as $photo_file)
                    <a href="{{ asset('images/business/' . $photo_file) }}"
                       class="fs-slider-item d-block slider-image-height"
                       data-fancybox="gallery"
                       data-caption="Showing image - {{ $photo_file }}">
                        <img src="{{ asset('images/business/' . $photo_file) }}"
                             alt="single listing image">
                    </a>
                @endforeach
            </div>
        @endif
    </section>
    <!-- =====END FULL SCREEN SLIDER======= -->

    <!-- =====START BREADCRUMB AREA======= -->
    <section class="breadcrumb-area bg-gradient-gray py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div
                        class="breadcrumb-content breadcrumb-content-2 d-flex flex-wrap align-items-end justify-content-between">
                        <div class="section-heading">
                            <ul class="list-items bread-list bread-list-2 bg-transparent rounded-0 p-0 text-capitalize">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li>
                                    <a href="{{ route('state.wise.organizations', $organization->state->slug) }}">{{ $organization->state->name }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('city.wise.organizations', ['state_slug' => $city->state->slug, 'city_slug' => $city->slug]) }}">{{ $organization->city->name }}</a>
                                </li>
                                <li>{{ $organization->organization_name }}</li>
                            </ul>
                            <div class="d-flex align-items-center pt-1">
                                <h1 class="sec__title mb-0">{{ $organization->organization_name }}</h1>

                                @if($organization->is_claimed)
                                    <div class="hover-tooltip-box ml-3 pt-2">
                                        <span class="text-color"><i class="la la-check-circle mr-1 text-color-4"></i>Claimed</span>
                                        <div class="hover-tooltip">
                                            <p>This business has been claimed by the owner or a representative.</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="hover-tooltip-box ml-3 pt-2">
                                        <a href="{{ route('claim.business', $organization->slug) }}"
                                           class="gradient-btn btn-sm claim-button">
                                            <i class="la la-check-circle mr-1 text-color-17"></i>Claim</a>
                                        <div class="hover-tooltip">
                                            <p>If you are the owner or representative of this business, you can claim it
                                                by
                                                following the appropriate steps.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <p class="sec__desc py-2 font-size-17"><i
                                    class="la la-map-marker mr-1 text-color-16"></i>
                                @if($organization->organization_address)
                                    {{ str_replace('Address: ', '', $organization->organization_address) }}
                                @else
                                    {{ ucfirst($organization->city->name) }}, {{ ucfirst($organization->state->name) }},
                                    US
                                @endif
                            </p>
                            <p class="pb-2 font-weight-medium">
                            <span class="price-range mr-1 text-color font-size-16" data-toggle="tooltip"
                                  data-placement="top" title="Moderate">
                                <strong class="font-weight-medium">{{ $organization->price_policy ?? '$' }}</strong>
                            </span>
                                <span class="category-link text-capitalize">
                                        {{ $organization->organization_category ?? $organization->category->name }}
                                </span>
                            </p>
                            <div class="d-flex flex-wrap align-items-center">
                                @if($organization->rate_stars && $organization->reviews_total_count)
                                    <div class="star-rating-wrap d-flex align-items-center">
                                        <div class="organization_rating"
                                             data-rating="{{ $organization->rate_stars }}"></div>
                                        <p class="font-size-14 pl-2 font-weight-medium">{{ $organization->reviews_total_count }}
                                            reviews</p>
                                    </div>
                                @endif
                            </div>
                            <div class="btn-box pt-3">
                                <a href="#review" class="btn-gray mr-1"><i class="la la-star mr-1"></i>Write a
                                    Review</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======END BREADCRUMB AREA======= -->

    <!-- =======START LISTING DETAIL AREA====== -->
    <section class="listing-detail-area padding-top-60px padding-bottom-100px">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="listing-detail-wrap">
                        <div class="block-card mb-4">
                            <div class="block-card-header">
                                <h2 class="widget-title">About</h2>
                                <div class="stroke-shape"></div>
                            </div>
                            <div class="block-card-body">
                                <p class="pb-3 font-weight-medium line-height-30">{!! $organization->about1 !!}</p>
                                <p class="pb-3 font-weight-medium line-height-30">{!! $organization->about2 !!}</p>
                                <p class="pb-3 font-weight-medium line-height-30">{!! $organization->about3 !!}</p>
                            </div>
                        </div>

                        @if($organization->organization_short_description)
                            <div class="block-card mb-4">
                                <div class="block-card-header">
                                    <h2 class="widget-title">Description</h2>
                                    <div class="stroke-shape"></div>
                                </div>
                                <div class="block-card-body">
                                    <p class="pb-3 font-weight-medium line-height-30">{{ $organization->organization_short_description }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="block-card mb-4">
                            <div class="block-card-header">
                                <h2 class="widget-title">Location / Contact</h2>
                                <div class="stroke-shape"></div>
                            </div>
                            <div class="block-card-body">
                                @if($organization->embed_map_code)
                                    <div class="map-container height-500">
                                        <div id="map" rel="nofollow">{!! $organization->embed_map_code !!}</div>
                                    </div>
                                @endif
                                <ul class="list-items list--items list-items-style-2 py-4">
                                    @if($organization->organization_address)
                                        <li><span class="text-color"><i
                                                    class="la la-map mr-2 text-color-16 font-size-18"></i>Address:</span>
                                            {{ str_replace('Address: ', '', $organization->organization_address) }}
                                        </li>
                                    @endif
                                    @if($organization->organization_phone_number)
                                        <li><span class="text-color"><i
                                                    class="la la-phone mr-2 text-color-16 font-size-18"></i>Phone:</span><a
                                                href="tel:{{ $organization->organization_phone_number }}">{{ $organization->organization_phone_number }}</a>
                                        </li>
                                    @endif
                                    @if($organization->organization_email)
                                        <li><span class="text-color"><i
                                                    class="la la-envelope mr-2 text-color-16 font-size-18"></i>Email:</span><a
                                                href="mailto:{{$organization->exploded_organization_email[0]}}">{{ $organization->exploded_organization_email[0] }}</a>
                                        </li>
                                    @endif
                                    @if($organization->organization_website)
                                        <li><span class="text-color"><i
                                                    class="la la-globe mr-2 text-color-16 font-size-18"></i>Website:</span><a
                                                rel="nofollow"
                                                href="{{ 'https://' . $organization->organization_website }}"
                                                target="_blank">{{ $organization->organization_website }}</a>
                                        </li>
                                    @endif
                                </ul>
                                <ul class="social-profile social-profile-styled">
                                    @if($organization->organization_facebook)
                                        <li><a rel="nofollow"
                                               href="{{ $organization->exploded_organization_facebook[0] }}"
                                               class="facebook-bg"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Facebook" target="_blank"><i class="lab la-facebook-f"></i></a>
                                        </li>
                                    @endif
                                    @if($organization->organization_twitter)
                                        <li><a rel="nofollow"
                                               href="{{ $organization->exploded_organization_twitter[0] }}"
                                               class="twitter-bg"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Twitter" target="_blank"><i class="lab la-twitter"></i></a></li>
                                    @endif
                                    @if($organization->organization_instagram)
                                        <li><a rel="nofollow"
                                               href="{{ $organization->exploded_organization_instagram[0] }}"
                                               class="instagram-bg"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Instagram" target="_blank"><i class="lab la-instagram"></i></a>
                                        </li>
                                    @endif
                                    @if($organization->organization_youTube)
                                        <li><a rel="nofollow"
                                               href="{{ $organization->exploded_organization_youTube[0] }}"
                                               class="youtube-bg"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Youtube" target="_blank"><i class="la la-youtube"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        @if($organization->rate_stars && $organization->reviews_total_count)
                            <div class="block-card mb-4" id="business-reviews-card">
                                <div class="block-card-header">
                                    <h2 class="widget-title">Rating Stats</h2>
                                    <div class="stroke-shape"></div>
                                </div>
                                <div class="block-card-body">
                                    <div class="review-content d-flex flex-wrap align-items-center">
                                        <div class="review-rating-summary">
                                    <span class="stats-average__count">
                                       {{ $organization->rate_stars }}
                                    </span>
                                            <div class="star-rating-wrap">
                                                <p class="font-size-14 font-weight-medium">out of 5.0</p>
                                                <div class="organization_rating"
                                                     data-rating="{{ $organization->rate_stars }}"></div>
                                            </div>
                                        </div>
                                        <div
                                            class="review-bars d-flex flex-row flex-wrap flex-grow-1 align-items-center">
                                            <div class="review-bars-item">
                                                <span class="review-bars-name">{{ $five_star_reviews }} reviews</span>
                                                <div class="review-bars-inner d-flex w-100 align-items-center">
                                            <span class="review-bars-review" data-rating="5.0">
                                                <span class="review-bars-review-inner"></span>
                                            </span>
                                                    <span class="pill">5.0</span>
                                                </div>
                                            </div>
                                            <div class="review-bars-item">
                                                <span class="review-bars-name">{{ $four_star_reviews }} reviews</span>
                                                <div class="review-bars-inner d-flex w-100 align-items-center">
                                            <span class="review-bars-review" data-rating="4.0">
                                                <span class="review-bars-review-inner"></span>
                                            </span>
                                                    <span class="pill">4.0</span>
                                                </div>
                                            </div>
                                            <div class="review-bars-item">
                                                <span class="review-bars-name">{{ $three_star_reviews }} reviews</span>
                                                <div class="review-bars-inner d-flex w-100 align-items-center">
                                            <span class="review-bars-review" data-rating="3.0">
                                                <span class="review-bars-review-inner"></span>
                                            </span>
                                                    <span class="pill">3.0</span>
                                                </div>
                                            </div>
                                            <div class="review-bars-item">
                                                <span class="review-bars-name">{{ $two_star_reviews }} reviews</span>
                                                <div class="review-bars-inner d-flex w-100 align-items-center">
                                            <span class="review-bars-review" data-rating="2.0">
                                                <span class="review-bars-review-inner"></span>
                                            </span>
                                                    <span class="pill">2.0</span>
                                                </div>
                                            </div>
                                            <div class="review-bars-item">
                                                <span class="review-bars-name">{{ $one_star_reviews }} reviews</span>
                                                <div class="review-bars-inner d-flex w-100 align-items-center">
                                            <span class="review-bars-review" data-rating="1.0">
                                                <span class="review-bars-review-inner"></span>
                                            </span>
                                                    <span class="pill">1.0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($organization->reviews->count())
                            <div class="block-card mb-4">
                                    <div class=" pb-4">
                                        <h2 class="widget-title">Reviews <span class="ml-1 text-color-16">({{ $organization->reviews->whereNotNull('review_id')->count() }})</span>
                                        </h2>
                                        <div class="stroke-shape"></div>
                                    </div>

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item google-review" role="presentation">
                                            <button class="nav-link active" id="google-tab" data-toggle="tab"
                                                    data-target="#google-review" type="button" role="tab"
                                                    aria-controls="google-review" aria-selected="true"><img
                                                    class="review-logo" src="{{asset('/images/google-logo.png')}}"
                                                    alt="Logo"> Google
                                                <span>({{ $organization->reviews->whereNotNull('review_id')->count() }})</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nebraska-review" id="nebraska-review-tab"
                                                    data-toggle="tab"
                                                    data-target="#nebraska-review" type="button" role="tab"
                                                    aria-controls="nebraska-review"
                                                    aria-selected="false"><img class="review-logo"
                                                                               src="{{asset('/images/favicon.png')}}"
                                                                               alt="Logo"> GymNearX
                                                <span class="nebraska-review-count"> ({{ $organization->reviews->whereNull('review_id')->count() }})</span>
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="reviewTabContent">
                                        <div class="tab-pane fade show active" id="google-review" role="tabpanel"
                                             aria-labelledby="google-tab">
                                            <div class="block-card-body">
                                                <div class="comments-list">
                                                    @foreach($organization->reviews_paginator as $review)
                                                        <div class="comment">
                                                            @if($review->reviewer_name)
                                                                <div class="user-thumb user-thumb-lg flex-shrink-0">
                                                                    <img
                                                                        src="{{ Avatar::create($review->reviewer_name)->toBase64() }}"
                                                                        alt="author-img">
                                                                </div>
                                                            @else
                                                                <div class="user-thumb user-thumb-lg flex-shrink-0">
                                                                    <img src="{{ asset('images/bb.png') }}"
                                                                         alt="author-img">
                                                                </div>
                                                            @endif
                                                            <div class="comment-body">
                                                                <div
                                                                    class="meta-data d-flex align-items-center justify-content-between">
                                                                    <div>
                                                                        <h4 class="comment__title">{{ $review->reviewer_name }}</h4>
                                                                    </div>
                                                                    <div class="star-rating-wrap text-center">
                                                                        <div class="users_review_ratings"
                                                                             data-rating="{{ $review->review_rate_stars }}">
                                                                        </div>
                                                                        @if($review->review_date)
                                                                            <p class="font-size-13 font-weight-medium">{{ Carbon::parse($review->review_specified_date)->diffForHumans() }}</p>
                                                                        @else
                                                                            <p class="font-size-13 font-weight-medium">{{ Carbon::parse($review->created_at)->diffForHumans() }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <p class="comment-desc">{{ $review->review_text_original }}</p>

                                                                @if($review->review_photos_files)
                                                                    <div
                                                                        class="review-photos d-flex flex-wrap align-items-center ml-n1 mb-3">
                                                                        @foreach(explode(',', $review->review_photos_files) as $photo_file)
                                                                            <a href="{{ asset('images/business/' . $photo_file) }}"
                                                                               class="d-inline-block"
                                                                               data-fancybox="gallery">
                                                                                <img class="lazy"
                                                                                     src="{{ asset('images/business/' . $photo_file) }}"
                                                                                     data-src="{{ asset('images/business/' . $photo_file) }}"
                                                                                     alt="review image" loading="lazy">
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                @if($review->review_thumbs_up_value)
                                                                    <div
                                                                        class="comment-action d-flex align-items-center justify-content-between float-right">
                                                                        <p class="feedback-box ">
                                                                            <button type="button"
                                                                                    class="btn-gray btn-gray-sm mr-1">
                                                                                <i class="fa-solid fa-thumbs-up"></i> <span
                                                                                    class="text-color font-weight-semi-bold">{{ $review->review_thumbs_up_value }}</span>
                                                                            </button>
                                                                        </p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @if ($organization->reviews_paginator->hasPages())
                                                    <div class="text-center padding-bottom-10px">
                                                        <div class="pagination-wrapper d-inline-block">
                                                            <div class="section-pagination">
                                                                <nav aria-label="Page navigation"
                                                                     class="pagination-desktop">
                                                                    {{ $organization->reviews_paginator->onEachSide(1)->links() }}
                                                                </nav>
                                                                <nav aria-label="Page navigation"
                                                                     class="pagination-mobile">
                                                                    {{ $organization->reviews_paginator->onEachSide(0)->links() }}
                                                                </nav>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nebraska-review" role="tabpanel"
                                             aria-labelledby="nebraska-review-tab">
                                            @if(count($organization->own_reviews_paginator))
                                                <div class="block-card-body">
                                                    <div class="comments-list">
                                                        @foreach($organization->own_reviews_paginator as $own_review)
                                                            <div class="comment">
                                                                @if($own_review->reviewer_name)
                                                                    <div class="user-thumb user-thumb-lg flex-shrink-0">
                                                                        <img
                                                                            src="{{ Avatar::create($own_review->reviewer_name)->toBase64() }}"
                                                                            alt="author-img">
                                                                    </div>
                                                                @else
                                                                    <div class="user-thumb user-thumb-lg flex-shrink-0">
                                                                        <img src="{{ asset('images/bb.png') }}"
                                                                             alt="author-img">
                                                                    </div>
                                                                @endif
                                                                <div class="comment-body">
                                                                    <div
                                                                        class="meta-data d-flex align-items-center justify-content-between">
                                                                        <div>
                                                                            <h4 class="comment__title">{{ $own_review->reviewer_name }}</h4>
                                                                        </div>
                                                                        <div class="star-rating-wrap text-center">
                                                                            <div class="users_review_ratings"
                                                                                 data-rating="{{ $own_review->review_rate_stars }}">
                                                                            </div>
                                                                            @if($own_review->review_date)
                                                                                <p class="font-size-13 font-weight-medium">{{ Carbon::parse($own_review->review_specified_date)->diffForHumans() }}</p>
                                                                            @else
                                                                                <p class="font-size-13 font-weight-medium">{{ Carbon::parse($own_review->created_at)->diffForHumans() }}</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <p class="comment-desc">{{ $own_review->review_text_original }}</p>

                                                                    @if($own_review->review_photos_files)
                                                                        <div
                                                                            class="review-photos d-flex flex-wrap align-items-center ml-n1 mb-3">
                                                                            @foreach(explode(',', $own_review->review_photos_files) as $photo_file)
                                                                                <a href="{{ asset('images/business/' . $photo_file) }}"
                                                                                   class="d-inline-block"
                                                                                   data-fancybox="gallery">
                                                                                    <img class="lazy"
                                                                                         src="{{ asset('images/business/' . $photo_file) }}"
                                                                                         data-src="{{ asset('images/business/' . $photo_file) }}"
                                                                                         alt="review image" loading="lazy">
                                                                                </a>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                    @if($own_review->review_thumbs_up_value)
                                                                        <div
                                                                            class="comment-action d-flex align-items-center justify-content-between float-right">
                                                                            <p class="feedback-box ">
                                                                                <button type="button"
                                                                                        class="btn-gray btn-gray-sm mr-1">
                                                                                    <i class="fa-solid fa-thumbs-up"></i>
                                                                                    <span
                                                                                        class="text-color font-weight-semi-bold">{{ $own_review->review_thumbs_up_value }}</span>
                                                                                </button>
                                                                            </p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if ($organization->own_reviews_paginator->hasPages())
                                                        <div class="text-center">
                                                            <div class="pagination-wrapper d-inline-block">
                                                                <div class="section-pagination">
                                                                    <nav aria-label="Page navigation">
                                                                        <nav aria-label="Page navigation"
                                                                             class="pagination-desktop">
                                                                            {{ $organization->own_reviews_paginator->onEachSide(1)->links() }}
                                                                        </nav>
                                                                        <nav aria-label="Page navigation"
                                                                             class="pagination-mobile">
                                                                            {{ $organization->own_reviews_paginator->onEachSide(0)->links() }}
                                                                        </nav>
                                                                    </nav>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="block-card-body">
                                                    <div class="comments-list">
                                                        <p class="text-dark">No reviews yet</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-center">
                                            <a rel="nofollow" href="{{ $organization->gmaps_link }}"
                                               class="more-review-link" target="_blank">For more reviews</a>
                                        </div>
                                    </div>
                            </div>
                        @endif

                        <div class="block-card mb-4">
                            <div class="block-card-header">
                                <h2 class="widget-title">Frequently Asked Questions</h2>
                                <div class="stroke-shape"></div>
                            </div>
                            <div class="block-card-body">
                                <div class="accordion-item" id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5>
                                                <button
                                                    class="btn btn-link d-flex align-items-center justify-content-between"
                                                    data-toggle="collapse" data-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                    How busy is this place?
                                                    <i class="la la-minus"></i>
                                                    <i class="la la-plus"></i>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                             data-parent="#accordion">
                                            <div class="card-body">
                                                <p>Except the peak hours,
                                                    this place remains quite free or moderately crowded.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5>
                                                <button
                                                    class="btn btn-link d-flex align-items-center justify-content-between"
                                                    data-toggle="collapse" data-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    What is the rating of this business?
                                                    <i class="la la-minus"></i>
                                                    <i class="la la-plus"></i>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                             data-parent="#accordion">
                                            <div class="card-body">
                                                <p>This business has a
                                                    rating of {{ $organization->rate_stars }}-star.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h5>
                                                <button
                                                    class="btn btn-link d-flex align-items-center justify-content-between"
                                                    data-toggle="collapse" data-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    How many reviews does this business have?
                                                    <i class="la la-minus"></i>
                                                    <i class="la la-plus"></i>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                             data-parent="#accordion">
                                            <div class="card-body">
                                                <p>This business
                                                    has {{ $organization->reviews->count() }} reviews.</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if($organization->organization_address)
                                        <div class="card">
                                            <div class="card-header" id="headingFour">
                                                <h5>
                                                    <button
                                                        class="btn btn-link d-flex align-items-center justify-content-between"
                                                        data-toggle="collapse" data-target="#collapseFour"
                                                        aria-expanded="false" aria-controls="collapseFour">
                                                        What is the address of this place?
                                                        <i class="la la-minus"></i>
                                                        <i class="la la-plus"></i>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                                 data-parent="#accordion">
                                                <div class="card-body">
                                                    <p>The address
                                                        is: {{ $organization->organization_address }}.</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="card">
                                        <div class="card-header" id="headingFive">
                                            <h5>
                                                <button
                                                    class="btn btn-link d-flex align-items-center justify-content-between"
                                                    data-toggle="collapse" data-target="#collapseFive"
                                                    aria-expanded="false" aria-controls="collapseFive">
                                                    What is the contact number of this service?
                                                    <i class="la la-minus"></i>
                                                    <i class="la la-plus"></i>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                                             data-parent="#accordion">
                                            <div class="card-body">
                                                @if($organization->organization_phone_number)
                                                    <p>The contact number is <a
                                                            href="tel:{{ $organization->organization_phone_number }}">{{ $organization->organization_phone_number }}</a>
                                                    </p>
                                                @else
                                                    <p>This business has not provided a phone number.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingSix">
                                            <h5>
                                                <button
                                                    class="btn btn-link d-flex align-items-center justify-content-between"
                                                    data-toggle="collapse" data-target="#collapseSix"
                                                    aria-expanded="false" aria-controls="collapseSix">
                                                    What category is this service listed under?
                                                    <i class="la la-minus"></i>
                                                    <i class="la la-plus"></i>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix"
                                             data-parent="#accordion">
                                            <div class="card-body">
                                                <p>This service is listed
                                                    under {{ Str::title($organization->category->name) }}.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="block-card-header pt-3">
                                    </div>

                                    <div class="pt-4">
                                        <h2 class="widget-title pb-1">Finally</h2>
                                    </div>
                                    <div class="pt-2">
                                        <p class="text-dark text-justify">
                                            <strong>{{ $organization->organization_name }}</strong> is a very
                                            picturesque
                                            and welcoming place for all. Come join with
                                            your friends or family, relax, take some good selfies and
                                            enjoy your time together. Thus, you can make it a memorable day for
                                            everyone.
                                        </p>
                                        @if($organization->organization_website || $organization->organization_facebook)
                                            <p class="text-dark pt-3">For more info about
                                                <strong>{{ $organization->organization_name }}</strong>, visit their
                                                @if($organization->organization_website)
                                                    <a rel="nofollow"
                                                       href="{{ 'https://' . $organization->organization_website }}"
                                                       target="_blank">{{ $organization->organization_website }}</a>.
                                                @elseif($organization->organization_facebook)
                                                    <a rel="nofollow" href="{{ $organization->organization_facebook }}"
                                                       target="_blank">Facebook</a>.
                                                @endif
                                            </p>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="block-card" id="review">
                            <div class="block-card-header">
                                <h2 class="widget-title pb-1">Add a Review</h2>
                                <p>Your email address will not be published. Required fields are marked <span
                                        class="required">*</span></p>
                            </div>
                            <div class="block-card-body">
                                <div
                                    class="add-rating-bars review-bars d-flex flex-row flex-wrap flex-grow-1 align-items-center">
                                    <span class="review-bars-name pr-3">Rate this business! <span
                                            class="required">*</span></span>
                                    <section class='rating-widget'>
                                        <div class='rating-stars text-center'>
                                            <ul id='stars'>
                                                <li class='star' title='Poor' data-value='1'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star' title='Fair' data-value='2'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star' title='Good' data-value='3'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star' title='Excellent' data-value='4'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                <li class='star' title='WOW!!!' data-value='5'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </section>
                                </div>
                                <form method="post" action="{{ route('review.store') }}" class="form-box row pt-3"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="review_rate_stars" id="review_rate_stars">
                                    <input type="hidden" name="organization_guid"
                                           value="{{ $organization->organization_guid }}">
                                    <div class="col-lg-6">
                                        <div class="input-box">
                                            <label class="label-text" for="reviewer_name">Name <span
                                                    class="required">*</span></label>
                                            <div class="form-group">
                                                <span class="la la-user form-icon"></span>
                                                <input class="form-control" type="text" name="reviewer_name"
                                                       id="reviewer_name"
                                                       placeholder="Your Name" value="{{ old('reviewer_name') }}"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-box">
                                            <label class="label-text" for="reviewer_email">Email <span
                                                    class="required">*</span></label>
                                            <div class="form-group">
                                                <span class="la la-envelope-o form-icon"></span>
                                                <input class="form-control" type="email" name="reviewer_email"
                                                       id="reviewer_email"
                                                       placeholder="Email Address" value="{{ old('reviewer_email') }}"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text" for="review_text_original">Review</label>
                                            <div class="form-group">
                                                <span class="la la-pencil form-icon"></span>
                                                <textarea class="message-control form-control"
                                                          name="review_text_original"
                                                          id="review_text_original"
                                                          placeholder="Tell about your experience or leave a tip for others">{{ old('review_text_original') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="file-upload-wrap file-upload-wrap-2">
                                            <input type="file" name="review_photos_files[]"
                                                   class="multi file-upload-input with-preview" multiple>
                                            <span class="file-upload-text"><i
                                                    class="la la-photo mr-2"></i>Add Photos</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="btn-box pt-3">
                                            <button class="theme-btn gradient-btn border-0">Submit Review<i
                                                    class="la la-arrow-right ml-2"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar mb-0">
                        <div class="suggest-edit-button-div">
                            <button type="button" class="btn btn-light suggest-edit-button" data-toggle="modal"
                                    data-target="#suggestEditModal">Suggest an Edit
                            </button>
                        </div>

                        @include('organization.partials.suggest_edit_modal')

                        @if($organization->organization_badge)
                            <button type="button" class="btn btn-light sidebar-widget-get-award"
                                    data-toggle="modal"
                                    data-target="#getYourAwardModal">
                                <img class="nebraska-badge-image"
                                     src="{{ asset('images/badges/' . $organization->organization_badge) }}"
                                     data-src="{{ asset('images/badges/' . $organization->organization_badge) }}"
                                     alt="GymNearX Badge">
                                <span class="text-center pt-4 font-weight-bold">Get your award certificate!</span>
                            </button>
                        @endif

                        <div class="sidebar-widget">
                            <h3 class="widget-title">General Information</h3>
                            <div class="stroke-shape mb-4"></div>
                            <ul class="list-items list-items-style-2">
                                @if($organization->organization_website)
                                    <li><i class="la la-external-link mr-2 text-color-16 font-size-18"></i><a
                                            rel="nofollow" href="{{ 'https://' . $organization->organization_website }}"
                                            target="_blank">{{ $organization->organization_website }}</a></li>
                                @endif
                                @if($organization->organization_phone_number)
                                    <li><i class="la la-phone mr-2 text-color-16 font-size-18"></i>
                                        <a href="tel:{{ $organization->organization_phone_number }}">{{ $organization->organization_phone_number }}</a>
                                    </li>
                                @endif
                                <li><i class="la la-map-signs mr-2 text-color-16 font-size-18"></i>
                                    <a rel="nofollow" href="{{ $organization->gmaps_link }}" target="_blank">Get
                                        Directions</a>
                                </li>
                            </ul>
                        </div>
                        @if($organization->organization_work_time)
                            <div class="sidebar-widget">
                                <h3 class="widget-title">Opening Hours</h3>
                                @if($organization->temporarily_closed)
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Temporarily closed</strong>
                                    </div>
                                @endif
                                <div class="stroke-shape mb-4"></div>
                                <ul class="list-items">
                                    @foreach($organization->organization_work_time_modified as $work_times)
                                        @php
                                            $exploded_work_time = explode(',', $work_times);
                                        @endphp
                                        @if($exploded_work_time[0] && $exploded_work_time[1])
                                            <li class="d-flex justify-content-between">{{ $exploded_work_time[0] }}
                                                <span>{{ $exploded_work_time[1] }}</span></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======END LISTING DETAIL  AREA======= -->
@endsection
@section('js')
    <script src="{{asset('plugins/ratings/src/jquery.star-rating-svg.js')}}"></script>
@endsection
@section('json-ld')
    <!-- =======Schema======= -->
    <script type="application/ld+json">
        {
          "@context": "https://schema.org/",
          "@type": "Organization",
          "name": "{{$organization->organization_name}}",
          "description": "{{ $organization->organization_short_description }}",
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "{{ $organization->rate_stars }}",
            "reviewCount": "{{ $organization->reviews->count() ?? 0}}"
          }
        }
    </script>
@endsection
