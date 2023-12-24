@extends('layouts.master')
@section('title', config('app.name') . " THE Local Business Directory | near me")
@section('meta_description', "Browse near by all gyms.")
@section('meta_keywords',"USA, gymnearx, gymnearme")
@section('content')
    @if($organizations)
        <!-- =====START BREADCRUMB AREA==== -->
        <section class="breadcrumb-area bg-gradient-gray py-4">
            <div class="container-fluid padding-right-40px padding-left-40px slide-image-top">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
                            <div class="section-heading text-capitalize">
                                <h2 class="sec__title font-size-26 mb-0">{{ $organizations[0]->organization_category }}
                                    near {{ $organizations[0]->state->name }}, {{ $organizations[0]->city->name }}</h2>
                            </div>
                            <ul class="list-items bread-list bread-list-2 text-capitalize">
                                <li><a href="/">Home</a></li>
                                <li>{{ $organizations[0]->organization_category }}
                                    near you
                                </li>
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
                            <div class="col-lg-12 responsive-column-lg">
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
        <section class="breadcrumb-area bg-gradient-gray py-4">
            <div class="container-fluid padding-right-40px padding-left-40px slide-image-top">
                <div class="row">
                    <div class="col-lg-12 p-5 text-center font-size-35">
                        <p>No Gyms Found Near You</p>
                    </div>
                </div>
            </div>
        </section>
    @endif
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
                var searchTerm = $(this).val().toLowerCase().trim(); // Get the search term

                var visibleOrganizations = 0; // Variable to count visible organization cards

                // Iterate through each gym location card and filter based on the search term
                $('.near_me_organizations-card-item').each(function () {
                    var cardText = $(this).text().toLowerCase(); // Get the text content of the card
                    var matchFound = cardText.includes(searchTerm); // Check for match

                    // Show or hide the gym location card based on the search term match
                    $(this).toggle(matchFound);

                    // Increment the count of visible organization cards if it's matched
                    if (matchFound) {
                        visibleOrganizations++;
                    }
                });

                // Update the organization count text
                $('.organization-count').text('(' + visibleOrganizations);

                var anyMarkerVisible = false; // Variable to track if any marker is visible

                // Filter map markers based on the search term
                mapMarkers.forEach(function (marker, index) {
                    var location = locations[index];

                    // Check if the location exists and has the required properties
                    if (location && (location.name || location.address)) {
                        var markerTitle = (location.name || '').toLowerCase();
                        var markerAddress = (location.address || '').toLowerCase();
                        var markerRateStars = (location.rate_stars || '').toLowerCase();
                        var markerReviewsTotalCount = (location.reviews_total_count || '').toLowerCase();

                        // Add other relevant marker information for searching
                        var matchFound =
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
