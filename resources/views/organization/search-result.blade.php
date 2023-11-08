@extends('layouts.master')
{{--@section('title', "$s_state->meta_title")--}}
@if (count($organizations) && $organizations->currentPage() > 1)
    @section('meta')
        <meta name="robots" content="noindex, follow">
    @endsection
@endif
{{--@section('meta_description', "Explore the best gym in $s_state->name , " . Str::title($city->name) . ", Get photos, business hours, phone numbers, ratings, reviews and service details.")--}}
{{--@section('meta_keywords', "$s_state->name in $city->name, $s_state->name in $city->name near me")--}}
@section('content')
    <section class="card-area section-padding">
        <div class="container pt-5">
            <div class="row">
                @forelse($organizations as $organization)
                    <div class="col-lg-4 responsive-column">
                        <div class="card-item">
                            <div class="card-image">
                                <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}"
                                   class="d-block">
                                    @if($organization->organization_head_photo_file)
                                        <img
                                            src="{{ asset('images/business/' . $organization->organization_head_photo_file) }}"
                                            data-src="{{ asset('images/business/' . $organization->organization_head_photo_file) }}"
                                            class="card__img lazy search-result-img"
                                            alt="{{ $organization->organization_name }}" loading="lazy">
                                    @else
                                        <img src="{{ asset('images/default.jpg') }}"
                                             data-src="{{ asset('images/default.jpg') }}"
                                             class="card__img lazy search-result-img"
                                             alt="{{ $organization->organization_name }}" loading="lazy">
                                    @endif
                                </a>
                                </span>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">
                                    <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}">{{ $organization->organization_name }}</a>
                                </h4>
                                <p class="card-sub">
                                    <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}">
                                        <i class="la la-map-marker mr-1 text-color-5"></i>
                                        @if($organization->organization_address)
                                            {{ str_replace('Address: ', '', $organization->organization_address) }}
                                        @else
                                            {{ ucfirst($organization->city->name) }}
                                            , {{ ucfirst($organization->state->name) }}, US
                                        @endif
                                    </a>
                                </p>
                                <ul class="listing-meta d-flex align-items-center">
                                    @if($organization->rate_stars && $organization->reviews_total_count)
                                        <li class="d-flex align-items-center">
                                            <span class="rate flex-shrink-0">{{ $organization->rate_stars }}</span>
                                            <span
                                                class="rate-text">{{ $organization->reviews_total_count }} Reviews</span>
                                        </li>
                                    @else
                                        <li class="d-flex align-items-center">
                                            <span class="rate flex-shrink-0">0.0</span>
                                            <span class="rate-text">0 Reviews</span>
                                        </li>
                                    @endif

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
                        </div><!-- end card-item -->
                    </div><!-- end col-lg-4 -->
                @empty
                    <div class="col-lg-12">
                        <div class="alert alert-danger text-center">
                            <h4 class="alert-heading">No Organization Found</h4>
                            <p>Sorry, we couldn't find any organization matching your search criteria.</p>
                        </div>
                    </div>
                @endforelse
            </div><!-- end row -->
            <div class="row">
                <div class="col-lg-12 pt-3 text-center">
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
                </div>
            </div>
        </div>
    </section>
@endsection
