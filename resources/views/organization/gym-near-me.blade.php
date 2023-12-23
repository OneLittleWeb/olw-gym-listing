@extends('layouts.master')
@section('title', config('app.name') . " THE Local Business Directory | near me")
@section('meta_description', "Browse near by all gyms.")
@section('meta_keywords',"USA, gymnearx, gymnearme")
@section('content')

    <!-- =====START BREADCRUMB AREA==== -->
    <section class="breadcrumb-area bg-gradient-gray py-4">
        <div class="container-fluid padding-right-40px padding-left-40px slide-image-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
                        <div class="section-heading text-capitalize">
                            @if($organizations)
                                <h2 class="sec__title font-size-26 mb-0">{{ $organizations[0]->organization_category }}
                                    near {{ $organizations[0]->state->name }}, {{ $organizations[0]->city->name }}</h2>
                            @else
                                <h2 class="sec__title font-size-26 mb-0">Find a gym near you</h2>
                            @endif
                        </div>
                        <ul class="list-items bread-list bread-list-2 text-capitalize">
                            <li><a href="/">Home</a></li>
                            @if($organizations)
                                <li>{{ $organizations[0]->organization_category }}
                                    near you
                                </li
                            @else
                                <li>Find a gym near you</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====END BREADCRUMB AREA==== -->

    <!-- ===START FULL SCREEN AREA=== -->
    <section class="full-screen-container d-flex">
        <div class="w-25 card-area">
            <div class="filter-bar-wrap padding-left-30px padding-right-30px pb-3 bg-light-blue">
                <form method="post" class="form-box row pt-4">
                    <div class="col-lg-12 input-box">
                        <div class="form-group">
                            <span class="la la-search form-icon"></span>
                            <input class="form-control" type="search" name="text"
                                   placeholder="Search by City & State or Zip Code">
                        </div>
                    </div>
                </form>
                <div
                    class="d-flex flex-wrap justify-content-between align-items-center shadow-none rounded-0 border-0 px-0">
                    <p class="result-text font-weight-medium font-size-14 text-color-18"><i
                            class="la la-map-marker mr-1"></i> We Found These Locations Near You
                        ({{ $organizations->count() }}
                        Results)</p>
                </div>
            </div>
            <div class="near-me-business-area">
                <div class="row pt-4 padding-left-30px padding-right-30px">
                    @foreach($organizations as $organization)
                        <div class="col-lg-12 responsive-column-lg">
                            <div class="card-item">
                                <div class="card-content" id="card_content_specific_business_{{ $loop->index }}">
                                    <h4 class="card-title">
                                        <a href="#">{{ $organization->organization_name }}</a>
                                    </h4>
                                    <p class="card-sub">
                                        <a href="#"><i class="la la-map-marker mr-1 text-color-2"></i>
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
                                                        <span
                                                            class="rate flex-shrink-0">{{ $organization->rate_stars }}</span>
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
                                            <i class="la la-route mr-1 listing-icon"></i>
                                            <a href="#" class="listing-cat-link">
                                                @if($organization->distance < 1)
                                                    {{ number_format($organization->distance * 1000, 2)}} meters
                                                @else
                                                    {{ number_format($organization->distance, 2) }} km
                                                @endif
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-55 main-map-area">
            <div class="map-container height-715">
                <div id="myMap"></div>
            </div>
        </div>
        <div class="w-20 category-near-me">
            <div class="sidebar mb-0">
                <div class="sidebar-widget">
                    <h3 class="widget-title">Other Fitness Centers Near You</h3>
                    <div class="stroke-shape mb-4"></div>
                    <ul class="tag-list">
                        @foreach($organizations->organization_categories as $category)
                            <li><a href="#">{{ $category->organization_category }} ({{ $category->category_count }})</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- ===END FULL SCREEN AREA=== -->
@endsection

@section('js')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const locations = {!! $locations ?? '[]' !!};

            if (!Array.isArray(locations) || locations.length === 0) {
                console.error('Locations data is invalid or empty.');
                return;
            }

            const mapElement = document.getElementById('myMap');

            if (!mapElement) {
                console.error('Map element not found.');
                return;
            }

            const map = L.map('myMap').setView([0, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            let firstMarker = null;
            let hoveredMarker = null;

            locations.forEach((location, index) => {
                const marker = L.marker([location.lat, location.lng]);

                const cardContentId = `#card_content_specific_business_${index}`;
                const cardContent = document.querySelector(cardContentId);

                const url = `/${location.city_slug}/gnx/${location.slug}`;
                const imagePath = '{{ asset("images/business/") }}' + '/' + location.head_photo;

                let distanceDisplay = '';
                if (location.distance < 1) {
                    const distanceInMeters = (location.distance * 1000).toFixed(2);
                    distanceDisplay = `${distanceInMeters} meters`;
                } else {
                    const distanceInKm = location.distance.toFixed(2);
                    distanceDisplay = `${distanceInKm} km`;
                }

                const popupContent = `
                <a href="${url}" target="_blank">
                    <b>${location.name}</b>
                </a>
                <br>
                <a href="${url}" target="_blank">
                    <img src="${imagePath}" alt="Organization Image" style="max-width: 100px;">
                </a>
                <br>
                <b>${distanceDisplay}</b>
            `;

                marker.bindPopup(popupContent);

                marker.on('mouseover', function (e) {
                    this.openPopup();
                    hoveredMarker = this;
                    if (cardContent) {
                        cardContent.classList.add('active'); // Add a class to the card content
                    }
                });

                marker.on('mouseout', function (e) {
                    if (hoveredMarker !== this) {
                        this.closePopup();
                    }
                    if (cardContent) {
                        cardContent.classList.remove('active'); // Remove the class when mouse leaves
                    }
                });

                // Hover effect for card content
                if (cardContent) {
                    cardContent.addEventListener('mouseover', function () {
                        marker.openPopup();
                        hoveredMarker = marker;
                        cardContent.classList.add('active');
                    });

                    cardContent.addEventListener('mouseout', function () {
                        if (hoveredMarker !== marker) {
                            marker.closePopup();
                        }
                        cardContent.classList.remove('active');
                    });
                }

                marker.addTo(map);

                // Store the first marker
                if (index === 0) {
                    firstMarker = marker;
                }
            });

            const latlngs = locations.map(location => [location.lat, location.lng]);
            map.fitBounds(latlngs);

            // Open the popup of the first marker by default
            if (firstMarker) {
                firstMarker.openPopup();
            }
        });
    </script>
@endsection


{{--@section('js')--}}
{{--    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const locations = {!! $locations ?? '[]' !!};--}}

{{--            if (!Array.isArray(locations) || locations.length === 0) {--}}
{{--                console.error('Locations data is invalid or empty.');--}}
{{--                return;--}}
{{--            }--}}

{{--            const mapElement = document.getElementById('myMap');--}}

{{--            if (!mapElement) {--}}
{{--                console.error('Map element not found.');--}}
{{--                return;--}}
{{--            }--}}

{{--            const map = L.map('myMap').setView([0, 0], 2);--}}

{{--            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {--}}
{{--                maxZoom: 19,--}}
{{--            }).addTo(map);--}}

{{--            let firstMarker = null;--}}

{{--            locations.forEach((location, index) => {--}}
{{--                const marker = L.marker([location.lat, location.lng]);--}}

{{--                const cardContentId = `#card_content_specific_business_${index}`;--}}
{{--                const cardContent = document.querySelector(cardContentId);--}}

{{--                const url = `/${location.city_slug}/gnx/${location.slug}`;--}}
{{--                const imagePath = '{{ asset("images/business/") }}' + '/' + location.head_photo;--}}

{{--                let distanceDisplay = '';--}}
{{--                if (location.distance < 1) {--}}
{{--                    const distanceInMeters = (location.distance * 1000).toFixed(2);--}}
{{--                    distanceDisplay = `${distanceInMeters} meters`;--}}
{{--                } else {--}}
{{--                    const distanceInKm = location.distance.toFixed(2);--}}
{{--                    distanceDisplay = `${distanceInKm} km`;--}}
{{--                }--}}

{{--                const popupContent = `--}}
{{--                    <a href="${url}" target="_blank">--}}
{{--                        <b>${location.name}</b>--}}
{{--                    </a>--}}
{{--                    <br>--}}
{{--                    <a href="${url}" target="_blank">--}}
{{--                        <img src="${imagePath}" alt="Organization Image" style="max-width: 100px;">--}}
{{--                    </a>--}}
{{--                    <br>--}}
{{--                    <b>${distanceDisplay}</b>--}}
{{--                `;--}}

{{--                marker.bindPopup(popupContent);--}}

{{--                marker.on('mouseover', function (e) {--}}
{{--                    this.openPopup();--}}
{{--                    if (cardContent) {--}}
{{--                        cardContent.classList.add('active'); // Add a class to the card content--}}
{{--                    }--}}
{{--                });--}}

{{--                marker.on('mouseout', function (e) {--}}
{{--                    this.closePopup();--}}
{{--                    if (cardContent) {--}}
{{--                        cardContent.classList.remove('active'); // Remove the class when mouse leaves--}}
{{--                    }--}}
{{--                });--}}

{{--                // Hover effect for card content--}}
{{--                if (cardContent) {--}}
{{--                    cardContent.addEventListener('mouseover', function () {--}}
{{--                        marker.openPopup();--}}
{{--                        cardContent.classList.add('active');--}}
{{--                    });--}}

{{--                    cardContent.addEventListener('mouseout', function () {--}}
{{--                        marker.closePopup();--}}
{{--                        cardContent.classList.remove('active');--}}
{{--                    });--}}
{{--                }--}}

{{--                marker.addTo(map);--}}

{{--                // Store the first marker--}}
{{--                if (index === 0) {--}}
{{--                    firstMarker = marker;--}}
{{--                }--}}
{{--            });--}}

{{--            const latlngs = locations.map(location => [location.lat, location.lng]);--}}
{{--            map.fitBounds(latlngs);--}}

{{--            // Open the popup of the first marker by default--}}
{{--            if (firstMarker) {--}}
{{--                firstMarker.openPopup();--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
