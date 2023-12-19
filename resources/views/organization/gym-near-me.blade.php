@extends('layouts.master')
@section('title', config('app.name') . " THE Local Business Directory | States")
@section('meta_description', "Browse near by all gyms.")
@section('meta_keywords',"USA, gymnearx, gymnearme")
@section('content')

    <!-- ================================
    START BREADCRUMB AREA
================================= -->
    <section class="breadcrumb-area bg-gradient-gray py-4">
        <div class="container-fluid padding-right-40px padding-left-40px slide-image-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
                        <div class="section-heading text-capitalize">
                            @if($organizations)
                                <h2 class="sec__title font-size-26 mb-0">{{ $organizations[0]->organization_category }}
                                    near {{ $organizations[0]->city->name }}</h2>
                            @else
                                <h2 class="sec__title font-size-26 mb-0">Find a gym near you</h2>
                            @endif
                        </div>
                        <ul class="list-items bread-list bread-list-2 text-capitalize">
                            <li><a href="#">Home</a></li>
                            @if($organizations)
                                <li>{{ $organizations[0]->organization_category }}
                                    near {{ $organizations[0]->city->name }}</li
                            @else
                                <li>Find a gym near you</li>
                            @endif
                        </ul>
                    </div><!-- end breadcrumb-content -->
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end container-fluid -->
    </section><!-- end breadcrumb-area -->
    <!-- ================================
        END BREADCRUMB AREA
    ================================= -->

    <!-- ================================
       START FULL SCREEN AREA
================================= -->
    <section class="full-screen-container d-flex">
        <div class="w-30 card-area near-me-business-area">
            <div class="filter-bar-wrap padding-left-30px padding-right-30px">
                <form method="post" class="form-box row pt-4">
                    <div class="col-lg-12 input-box">
                        <div class="form-group">
                            <span class="la la-search form-icon"></span>
                            <input class="form-control" type="search" name="text"
                                   placeholder="Search by City & State or Zip Code">
                        </div>
                    </div>
                </form>
                <div class="d-flex flex-wrap justify-content-between align-items-center shadow-none rounded-0 border-0 px-0">
                    <p class="result-text font-weight-medium">Showing 1 to 6 of {{ $organizations->count() }}
                        locations</p>
                    <div class="filter-bar-action d-flex flex-wrap align-items-center">
                        <div class="user-chosen-select-container ml-3">
                            <select class="user-chosen-select">
                                <option value="sort-by-default">Sort by default</option>
                                <option value="high-rated">High Rated</option>
                                <option value="most-reviewed">Most Reviewed</option>
                                <option value="popular-Listing">Popular Listing</option>
                                <option value="newest-Listing">Newest Listing</option>
                                <option value="older-Listing">Older Listing</option>
                                <option value="price-low-to-high">Price: low to high</option>
                                <option value="price-high-to-low">Price: high to low</option>
                                <option value="all-listings">Random</option>
                            </select>
                        </div>
                    </div><!-- end filter-bar-action -->
                </div><!-- end filter-bar -->
            </div><!-- end filter-bar-wrap -->
            <div class="row pt-4 padding-left-30px padding-right-30px">
                <div class="col-lg-12 responsive-column-lg">
                    <div class="card-item">
                        <div class="card-content">
                            <h4 class="card-title">
                                <a href="#">Favorite Place Food Bank</a>
                            </h4>
                            <p class="card-sub"><a href="#"><i class="la la-map-marker mr-1 text-color-2"></i>Bishop
                                    Avenue, New York</a></p>
                            <ul class="listing-meta d-flex align-items-center">
                                <li class="d-flex align-items-center">
                                    <span class="rate flex-shrink-0">4.7</span>
                                    <span class="rate-text">5 Ratings</span>
                                </li>
                                <li>
                                <span class="price-range" data-toggle="tooltip" data-placement="top" title="Pricey">
                                    <strong class="font-weight-medium">$</strong>
                                    <strong class="font-weight-medium">$</strong>
                                    <strong class="font-weight-medium">$</strong>
                                </span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="la la-cutlery mr-1 listing-icon"></i><a href="#" class="listing-cat-link">Restaurant</a>
                                </li>
                            </ul>
                            <ul class="info-list padding-top-20px">
                                <li><span class="la la-link icon"></span>
                                    <a href="#"> www.gymnearx.com</a>
                                </li>
                                <li><span class="la la-calendar-check-o icon"></span>
                                    Opened 1 month ago
                                </li>
                            </ul>
                        </div>
                    </div><!-- end card-item -->
                </div><!-- end col-lg-6 -->
                <div class="col-lg-12 responsive-column-lg">
                    <div class="card-item">
                        <div class="card-content">
                            <h4 class="card-title">
                                <a href="#">Beach Blue Boardwalk</a>
                            </h4>
                            <p class="card-sub"><a href="#"><i class="la la-map-marker mr-1 text-color-2"></i>Bishop
                                    Avenue, New York</a></p>
                            <ul class="listing-meta d-flex align-items-center">
                                <li class="d-flex align-items-center">
                                    <span class="rate flex-shrink-0">4.7</span>
                                    <span class="rate-text">5 Ratings</span>
                                </li>
                                <li>
                                <span class="price-range" data-toggle="tooltip" data-placement="top" title="Moderate">
                                    <strong class="font-weight-medium">$</strong>
                                    <strong class="font-weight-medium">$</strong>
                                </span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="la la-plane mr-1 listing-icon"></i><a href="#" class="listing-cat-link">Travel</a>
                                </li>
                            </ul>
                            <ul class="info-list padding-top-20px">
                                <li><span class="la la-link icon"></span>
                                    <a href="#"> www.gymnearx.com</a>
                                </li>
                                <li><span class="la la-calendar-check-o icon"></span>
                                    Opened 1 month ago
                                </li>
                            </ul>
                        </div>
                    </div><!-- end card-item -->
                </div><!-- end col-lg-6 -->
                <div class="col-lg-6 responsive-column-lg">
                    <div class="card-item">
                        <div class="card-image">
                            <a href="listing-details.html" class="d-block">
                                <img src="images/img-loading.png" data-src="images/img4.jpg" class="card__img lazy"
                                     alt="">
                            </a>
                            </span>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">
                                <a href="listing-details.html">Hotel Govendor</a>
                            </h4>
                            <p class="card-sub"><a href="#"><i class="la la-map-marker mr-1 text-color-2"></i>Bishop
                                    Avenue, New York</a></p>
                            <ul class="listing-meta d-flex align-items-center">
                                <li class="d-flex align-items-center">
                                    <span class="rate flex-shrink-0">4.7</span>
                                    <span class="rate-text">5 Ratings</span>
                                </li>
                                <li>
                                <span class="price-range" data-toggle="tooltip" data-placement="top"
                                      title="Inexpensive">
                                    <strong class="font-weight-medium">$</strong>
                                </span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="la la-hotel mr-1 listing-icon"></i><a href="#" class="listing-cat-link">Hotels</a>
                                </li>
                            </ul>
                            <ul class="info-list padding-top-20px">
                                <li><span class="la la-link icon"></span>
                                    <a href="#"> www.gymnearx.com</a>
                                </li>
                                <li><span class="la la-calendar-check-o icon"></span>
                                    Opened 1 month ago
                                </li>
                            </ul>
                        </div>
                    </div><!-- end card-item -->
                </div><!-- end col-lg-6 -->
                <div class="col-lg-6 responsive-column-lg">
                    <div class="card-item">
                        <div class="card-image">
                            <a href="listing-details.html" class="d-block">
                                <img src="images/img-loading.png" data-src="images/img4.jpg" class="card__img lazy"
                                     alt="">
                            </a>
                            </span>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">
                                <a href="listing-details.html">Hotel Govendor</a>
                            </h4>
                            <p class="card-sub"><a href="#"><i class="la la-map-marker mr-1 text-color-2"></i>Bishop
                                    Avenue, New York</a></p>
                            <ul class="listing-meta d-flex align-items-center">
                                <li class="d-flex align-items-center">
                                    <span class="rate flex-shrink-0">4.7</span>
                                    <span class="rate-text">5 Ratings</span>
                                </li>
                                <li>
                                <span class="price-range" data-toggle="tooltip" data-placement="top"
                                      title="Inexpensive">
                                    <strong class="font-weight-medium">$</strong>
                                </span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="la la-hotel mr-1 listing-icon"></i><a href="#" class="listing-cat-link">Hotels</a>
                                </li>
                            </ul>
                            <ul class="info-list padding-top-20px">
                                <li><span class="la la-link icon"></span>
                                    <a href="#"> www.gymnearx.com</a>
                                </li>
                                <li><span class="la la-calendar-check-o icon"></span>
                                    Opened 1 month ago
                                </li>
                            </ul>
                        </div>
                    </div><!-- end card-item -->
                </div><!-- end col-lg-6 -->
            </div><!-- end row -->
            <div class="row">
                <div class="col-lg-12 pt-3 text-center pb-5">
                    <div class="pagination-wrapper d-inline-block">
                        <div class="section-pagination">
                            <nav aria-label="Page navigation">
                                <ul class="pagination flex-wrap justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link page-link-first" href="#"><i
                                                class="la la-long-arrow-left mr-1"></i> First</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true"><i class="la la-angle-left"></i></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link page-link-active" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true"><i class="la la-angle-right"></i></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link page-link-last" href="#">Last <i
                                                class="la la-long-arrow-right ml-1"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div><!-- end section-pagination -->
                    </div>
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end card-area -->
        <div class="w-70 home-map">
            <div class="map-container height-980">
                <div id="myMap"></div>
                <a href="#" class="enable-scroll" title="Enable or disable scrolling on map">
                    <i class="la la-mouse mr-2"></i>Enable Scrolling
                </a>
            </div>
        </div><!-- Home Map End -->
    </section>
    <!-- ================================
           END FULL SCREEN AREA
    ================================= -->

    <section class="category-area">
        <div class="card">
            <div class="card-body">
                @forelse($organizations as $organization)
                    <p>{{ $organization->organization_name }} - {{ $organization->state->name }}
                        - {{ $organization->city->name }}
                        - {{ $organization->distance }}</p>
                @empty
                    <p>No gyms found.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const locations = {!! $locations ?? '[]' !!};

            console.log('Locations:', locations); // Log locations data

            if (!Array.isArray(locations)) {
                console.error('Locations is not an array.');
            } else if (locations.length === 0) {
                console.error('Locations array is empty.');
            } else {
                const mapElement = document.getElementById('myMap');
                if (!mapElement) {
                    console.error('Map element not found.');
                } else {
                    const map = L.map('myMap').setView([0, 0], 2); // Initialize map and set the view

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                    }).addTo(map);

                    let firstMarker = null; // To store the first marker with less distance

                    locations.forEach(location => {
                        const marker = L.marker([location.lat, location.lng]);

                        const url = `/${location.city_slug}/gnx/${location.slug}`;

                        // Image path for the popup content
                        const imagePath = '{{ asset("images/business/") }}' + '/' + location.head_photo;

                        let distanceDisplay = '';
                        if (location.distance < 1) {
                            // Display distance in meters if less than 1 km
                            const distanceInMeters = (location.distance * 1000).toFixed(2); // Convert km to meters
                            distanceDisplay = `${distanceInMeters} meters`;
                        } else {
                            // Display distance in kilometers with two decimal places
                            const distanceInKm = location.distance.toFixed(2);
                            distanceDisplay = `${distanceInKm} km`;
                        }

                        // Construct the HTML content for the popup including the clickable image
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

                        // Show popup on mouseover and prevent closing on mouseout
                        marker.on('mouseover', function (e) {
                            this.openPopup();
                        });

                        if (!firstMarker || location.distance < firstMarker.distance) {
                            firstMarker = {
                                distance: location.distance,
                                marker: marker,
                            };
                        }

                        marker.addTo(map);
                    });

                    // Fit the map to display all markers
                    const latlngs = locations.map(location => [location.lat, location.lng]);
                    map.fitBounds(latlngs);

                    // Automatically open popup for the marker with less distance
                    if (firstMarker) {
                        firstMarker.marker.openPopup();
                    }
                }
            }
        });
    </script>
@endsection
