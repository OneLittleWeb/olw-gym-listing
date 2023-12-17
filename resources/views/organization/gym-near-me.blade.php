@extends('layouts.master')
@section('title', config('app.name') . " THE Local Business Directory | States")
@section('meta_description', "Browse near by all gyms.")
@section('meta_keywords',"USA, gymnearx, gymnearme")
@section('content')
    <section class="category-area section--padding margin-top-40px">
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
        <div class="card">
            <div class="card-body">
                <div id="map" style="height: 500px;"></div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const locations = {!! $locations ?? '[]' !!};

            console.log('Locations:', locations); // Log locations data

            if (!Array.isArray(locations)) {
                console.error('Locations is not an array.');
            } else if (locations.length === 0) {
                console.error('Locations array is empty.');
            } else {
                const mapElement = document.getElementById('map');
                if (!mapElement) {
                    console.error('Map element not found.');
                } else {
                    const map = L.map('map').setView([0, 0], 2); // Initialize map and set the view

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
                            const distanceInMeters = (location.distance * 1000).toFixed(0); // Convert km to meters
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
