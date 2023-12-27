@extends('layouts.master')
@section('title', "Gymnearx THE Local Business Directory | Claim Your Business")
@section('meta_description', "Gymnearx, best places in the USA")
@section('meta')
<meta name="robots" content="noindex, follow">
@endsection
@section('content')
    <section>
        <div class="container main_container">
            <div class="row">
                <div class="col-lg-12">
                    <div
                        class="breadcrumb-content breadcrumb-content-2 d-flex flex-wrap align-items-end justify-content-between margin-bottom-30px">
                        <div class="section-heading">
                            <ul class="list-items bread-list bread-list-2 bg-transparent rounded-0 p-0 text-capitalize">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li>
                                    Claim Profile
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <h1 class="card-header">Claim Your Business Profile</h1>
                <div class="card-body text-dark">
                    <p class="card-text">Claim your ownership of <a
                            href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}">{{ $organization->organization_name }}</a>
                        profile page with one of the
                        methods below. After claiming a profile you will be able to edit all your business
                        information.</p>

                    <form method="post" action="{{ route('claim.business.profile', $organization->slug) }}">
                        @csrf
                        <div class="main-search-input-item user-chosen-select-container margin-top-10px">
                            <label>Business location <span class="required">*</span></label>
                            <select class="user-chosen-select" name="organization_city" id="organization_city">
                                @foreach($cities as $organization_city)
                                    <option class="text-capitalize"
                                            value="{{ $organization_city->id }}" {{ $organization_city->id == $organization->city_id ? 'selected' : '' }}>{{ $organization_city->name }}
                                        ,
                                        {{ $organization_city->state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div
                            class="main-search-input-item business-access-search-input-item user-chosen-select-container margin-top-10px">
                            <label>I have access to <span class="required">*</span></label>
                            <select class="user-chosen-select" name="organization_access" id="organization_access"
                                    onchange="businessAccess(event)" required>
                                <option class="text-capitalize" value="">-</option>
                                @if($organization->organization_website)
                                    <option class="text-capitalize" value="email_on_business_domain">Email on business
                                        domain
                                    </option>
                                @endif
                                <option class="text-capitalize" value="nothing_out_of_this">Nothing out of this</option>
                            </select>
                        </div><!-- end main-search-input-item -->

                        <div id="business_verification_data_div">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        function businessAccess(event) {
            let selected_value = event.target.value;
            let business_verification_data = document.getElementById('business_verification_data_div');
            if (selected_value === 'email_on_business_domain') {
                business_verification_data.innerHTML = '<p class="padding-top-20px">We will send an email with registration link</p>' +
                    '                        <div' +
                    '                            class="main-search-input-item business-access-search-input-item input-group margin-top-20px">' +
                    '                            <input class="form-control rounded-0 looking-for search-from-header" type="search" id="search-from-header"' +
                    '                                   name="business_email" autocomplete="off"' +
                    '                                   required>' +
                    '                            <div class="input-group-prepend">' +
                    '                                <span class="input-group-text"' +
                    '                                      id="organization_website">{{ '@' . $organization->organization_website }}</span>' +
                    '                            </div>' +
                    '                        </div>' +
                    '<div class="padding-top-20px">' +
                    '<button type="submit" class="btn btn-warning send-contact-button">Send</button>' +
                    '</div>';
            } else if (selected_value === 'nothing_out_of_this') {
                business_verification_data.innerHTML = '<p class="padding-top-20px"><a href="{{ route('contact.for.claim.business', $organization->slug) }}" target="_blank">Please contact us to continue the verification process</a></p>';
            } else {
                business_verification_data.innerHTML = '';
            }
        }
    </script>
@endsection
