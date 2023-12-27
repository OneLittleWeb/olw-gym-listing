@extends('layouts.master')
@section('title', $organizations ? Str::plural($organizations[0]->organization_category, $organization_category_count) . ' near me' : 'Gym Near Me')
@section('meta_description', "Browse near by all gyms.")
@section('meta_keywords',"USA, gymnearx, gymnearme")
@section('content')
    <!-- =====START BREADCRUMB AREA==== -->
    <section class="breadcrumb-area bg-gradient-gray near-me-popup-header py-4">
        <div class="container-fluid padding-right-40px padding-left-40px slide-image-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
                        <div class="section-heading text-capitalize">
                            <h2 class="sec__title font-size-26 mb-0">
                                {{ $organizations ? Str::plural($organizations[0]->organization_category, $organization_category_count) . ' near ' . $organizations[0]->state->name . ', ' . $organizations[0]->city->name : 'Gym Near Me' }}
                            </h2>
                        </div>
                        <ul class="list-items bread-list bread-list-2 text-capitalize">
                            <li><a href="/">Home</a></li>
                            <li>
                                {{ $organizations ? Str::plural($organizations[0]->organization_category, $organization_category_count) . ' near me' : 'Gym Near Me' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====END BREADCRUMB AREA==== -->
    @if($organizations)
        <!-- ===START FULL SCREEN AREA=== -->
        <section class="full-screen-container d-flex states-border-top">
            <div class="near-me-organization-section card-area">
                <div class="filter-bar-wrap padding-left-30px padding-right-30px pb-3 bg-light-blue">
                    <form method="post" class="form-box row pt-4">
                        <div class="col-lg-12 input-box">
                            <div class="form-group">
                                <span class="la la-search form-icon"></span>
                                <input class="form-control" type="search" name="gym_near_me" id="gym_near_me"
                                       placeholder="Search by Name or Zip Code">
                            </div>
                        </div>
                    </form>
                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center shadow-none rounded-0 border-0 px-0">
                        <p class="result-text font-weight-medium font-size-14 text-color-18"><i
                                class="la la-map-marker mr-1"></i> We Found These Locations Near You
                            <span class="organization-count">({{ $organizations->count() }}</span>
                            Results)</p>
                    </div>
                </div>
                <div class="near-me-business-area">
                    <div class="row pt-4 padding-left-30px padding-right-30px">
                        @foreach($organizations as $organization)
                            <div class="col-lg-12">
                                <div class="card-item near_me_organizations-card-item">
                                    <div class="card-content" id="card_content_specific_business_{{ $loop->index }}">
                                        <h4 class="card-title">
                                            <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}"
                                               target="_blank">{{ $organization->organization_name }}</a>
                                        </h4>
                                        <p class="card-sub">
                                            <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}"
                                               target="_blank"><i class="la la-map-marker mr-1 text-color-2"></i>
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
            <div class="near-me-map-section main-map-area">
                <div class="map-container near-me-map-container">
                    <div id="myMap"></div>
                </div>
            </div>
            <div class="near-me-category-section category-near-me">
                <div class="sidebar mb-0">
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Other Fitness Centers Near You</h3>
                        <div class="stroke-shape mb-4"></div>
                        <ul class="tag-list">
                            @foreach($organizations->organization_categories as $category)
                                @if($category->organization_category && $category->organization_category_slug != $organization_category_slug)
                                    <li>
                                        <a href="{{ route('gym.near.me', ['category_slug' => $category->organization_category_slug, 'suffix' => 'near-me']) }}">
                                            {{ $category->organization_category }} ({{ $category->category_count }})
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- ===END FULL SCREEN AREA=== -->
    @else
        <section class="bg-gradient-gray py-4">
            <div class="container-fluid padding-right-40px padding-left-40px slide-image-top">
                <div class="row">
                    <div class="col-lg-12 text-center font-size-35 margin-top--62">
                        <p>No Gyms Found Near You</p>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <div class="container-fluid margin-top-20px p-4">
        <div class="row">
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
                                            <ul class="row pl-1">
                                                @foreach($state->cities as $city)
                                                    <li class="col-lg-3 city-state-title">
                                                        <a class="text-decoration-underline"
                                                           href="{{ route('city.wise.organizations', ['state_slug' => $city->state->slug, 'city_slug' => $city->slug, 'organization_category_slug' => 'gym']) }}">{{ $city->name }}</a>
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
            <div class="row padding-bottom-30px">
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

@endsection

@section('js')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        const locations = {!! $locations ?? '[]' !!};
        const mapMarkers = []; // Array to store map markers
        let firstMarker = null;

        document.addEventListener('DOMContentLoaded', function () {
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

            // Disable zooming on touch devices
            if ('ontouchstart' in window || navigator.maxTouchPoints) {
                map.options.touchZoom = false;
            }

            map.scrollWheelZoom.disable(); // Disable scroll wheel zoom

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            let hoveredMarker = null;

            locations.forEach((location, index) => {
                const marker = L.marker([location.lat, location.lng]);

                const cardContentId = `#card_content_specific_business_${index}`;
                const cardContent = document.querySelector(cardContentId);

                const url = `/${location.city_slug}/gnx/${location.slug}`;
                const imagePath = '{{ asset("images/business/") }}' + '/' + location.head_photo;

                const popupContent = `
                    <div class="pb-2">
                        <a href="${url}" target="_blank">
                            <img class="near-me-popup-img" src="${imagePath}" alt="Organization Image">
                        </a>
                    </div>
                    <div class="pb-2 near-me-popup-header text-center">
                        <a class="font-size-15 line-height-15 text-capitalize" href="${url}" target="_blank">
                            <b>${location.name}</b>
                        </a>
                    </div>
                    <div class="pt-2 font-size-11">
                        <a rel="nofollow" href="${location.direction}" target="_blank">GET DIRECTION</a> | <a href="${url}" target="_blank">VISIT WEBSITE</a>
                    </div>
                    `;

                marker.bindPopup(popupContent);

                marker.on('mouseover', function (e) {
                    this.openPopup();
                    hoveredMarker = this;
                    if (cardContent) {
                        cardContent.classList.add('active');
                    }
                });

                marker.on('mouseout', function (e) {
                    if (hoveredMarker !== this) {
                        this.closePopup();
                    }
                    if (cardContent) {
                        cardContent.classList.remove('active');
                    }
                });

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
                mapMarkers.push(marker);

                if (index === 0) {
                    firstMarker = marker;
                }
            });

            const latlngs = locations.map(location => [location.lat, location.lng]);
            map.fitBounds(latlngs);

            if (firstMarker) {
                setTimeout(function () {
                    firstMarker.openPopup();
                }, 500);
            }
        });

        function updatePopupContent(marker, location) {
            const url = `/${location.city_slug}/gnx/${location.slug}`;
            const imagePath = '{{ asset("images/business/") }}' + '/' + location.head_photo;

            const popupContent = `
                <div class="pb-2">
                    <a href="${url}" target="_blank">
                        <img class="near-me-popup-img" src="${imagePath}" alt="Organization Image">
                    </a>
                </div>
                <div class="pb-2 near-me-popup-header text-center">
                    <a class="font-size-15 line-height-15 text-capitalize" href="${url}" target="_blank">
                        <b>${location.name}</b>
                    </a>
                </div>
                <div class="pt-2 font-size-11">
                    <a rel="nofollow" href="${location.direction}" target="_blank">GET DIRECTION</a> | <a href="${url}" target="_blank">VISIT WEBSITE</a>
                </div>
                `;

            marker.setPopupContent(popupContent);
        }

        $(document).ready(function () {
            $('#gym_near_me').on('keyup', function () {
                let searchTerm = $(this).val().toLowerCase().trim();

                let visibleOrganizations = 0; // Variable to count visible organization cards

                // Iterate through each gym location card and filter based on the search term
                $('.near_me_organizations-card-item').each(function () {
                    let cardText = $(this).text().toLowerCase(); // Get the text content of the card
                    let matchFound = cardText.includes(searchTerm); // Check for match

                    // Show or hide the gym location card based on the search term match
                    $(this).toggle(matchFound);

                    // Increment the count of visible organization cards if it's matched
                    if (matchFound) {
                        visibleOrganizations++;
                    }
                });

                // Update the organization count text
                $('.organization-count').text('(' + visibleOrganizations);

                let anyMarkerVisible = false; // Variable to track if any marker is visible

                // Filter map markers based on the search term
                mapMarkers.forEach(function (marker, index) {
                    let location = locations[index];

                    // Check if the location exists and has the required properties
                    if (location && (location.name || location.address)) {
                        let markerTitle = (location.name || '').toLowerCase();
                        let markerAddress = (location.address || '').toLowerCase();
                        let markerRateStars = (location.rate_stars || '').toLowerCase();
                        let markerReviewsTotalCount = (location.reviews_total_count || '').toLowerCase();

                        // Add other relevant marker information for searching
                        let matchFound =
                            markerTitle.includes(searchTerm) ||
                            markerAddress.includes(searchTerm) ||
                            markerRateStars.includes(searchTerm) ||
                            markerReviewsTotalCount.includes(searchTerm);

                        // Show or hide map markers based on the search term match
                        if (matchFound) {
                            marker.setOpacity(1); // Show the marker
                            updatePopupContent(marker, location); // Update popup content
                            marker.openPopup(); // Open the popup for the matched marker
                            anyMarkerVisible = true; // Set flag indicating at least one marker is visible
                        } else {
                            marker.setOpacity(0); // Hide the marker
                            marker.closePopup(); // Close the popup for non-matching markers
                        }

                        // Set first marker if it's the first marker or search is empty
                        if ((searchTerm === '' || searchTerm.length === 0) && index === 0) {
                            firstMarker = marker;
                        }
                    }
                });

                // Open the popup of the first marker when the search is cleared or empty
                if (searchTerm === '' || searchTerm.length === 0) {
                    firstMarker.openPopup();
                }

                // If no marker is visible, show all markers
                if (!anyMarkerVisible) {
                    mapMarkers.forEach(function (marker) {
                        marker.setOpacity(1); // Show all markers
                    });
                }
            });
        });
    </script>
@endsection
