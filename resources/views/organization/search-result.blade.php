@extends('layouts.master')
@section('title', "Search Result For $looking_for")
@if (count($organizations) && $organizations->currentPage() > 1)
    @section('meta')
        <meta name="robots" content="noindex, follow">
    @endsection
@endif
@section('meta_description', "Search Results For the $looking_for. Get photos, business hours, phone numbers, ratings, reviews and service details.")
@section('meta_keywords', "$looking_for")
@section('content')
    <section class="card-area section-padding">
        <div class="container pt-5">
            <div class="row">
                <div class="col-lg-12">
                    <div
                        class="breadcrumb-content breadcrumb-content-2 d-flex flex-wrap align-items-end justify-content-between margin-bottom-30px">
                        <ul class="list-items bread-list bread-list-2 bg-transparent rounded-0 p-0 text-capitalize">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                {{ $looking_for }}
                            </li>
                        </ul>
                    </div>

                    <div class="d-flex align-items-center pb-4 text-capitalize">
                        <h1 class="sec__title mb-0">Search Result For: <span
                                class="text-color-16">{{ $looking_for }}</span></h1>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                @forelse($organizations as $organization)
                    <div class="col-lg-4 responsive-column">
                        <div class="card-item">
                            <div class="card-image">
                                <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}"
                                   class="d-block">
                                    <img
                                        src="{{ asset('images/business/' . ($organization->organization_head_photo_file ?? 'default.jpg')) }}"
                                        data-src="{{ asset('images/business/' . ($organization->organization_head_photo_file ?? 'default.jpg')) }}"
                                        class="card__img lazy also_viewed_image"
                                        alt="{{ $organization->organization_name }}"
                                        loading="lazy">
                                </a>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">
                                    <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}">{{ $organization->organization_name }}</a>
                                </h4>
                                <p class="card-sub">
                                    <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}">
                                        <i class="la la-map-marker mr-1 text-color-5"></i>
                                        {{ $organization->organization_address ? str_replace('Address: ', '', $organization->organization_address) : ucfirst($organization->city->name) . ', ' . ucfirst($organization->state->name) . ', US' }}
                                    </a>
                                </p>
                                <ul class="listing-meta d-flex align-items-center">
                                    <li class="d-flex align-items-center">
                                        <span class="rate flex-shrink-0">
                                            {{ $organization->rate_stars ?? '0.0' }}
                                        </span>
                                        <span class="rate-text">
                                            {{ $organization->reviews_total_count ?? 0 }} Reviews
                                        </span>
                                    </li>

                                    <li class="d-flex align-items-center padding-left-20px">
                                        <i class="{{ $organization->category->icon }} mr-2 listing-icon"></i>
                                        <a href="#"
                                           class="listing-cat-link">{{ $organization->organization_category ?? $organization->category->name }}</a>
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
                @empty
                    <div class="col-lg-12">
                        <div class="alert alert-danger text-center">
                            <h4 class="alert-heading">No Business Found</h4>
                            <p>Sorry, we couldn't find any business matching your search criteria.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="row">
                <div class="col-lg-12 pt-3 text-center">
                    @if ($organizations->hasPages())
                        <div class="pagination-wrapper d-inline-block">
                            <div class="section-pagination">
                                <nav aria-label="Page navigation" class="pagination-desktop">
                                    {{ $organizations->onEachSide(1)->links() }}
                                </nav>
                                <nav aria-label="Page navigation" class="pagination-mobile">
                                    {{ $organizations->onEachSide(0)->links() }}
                                </nav>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
