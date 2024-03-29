@extends('layouts.master')
@section('title', "$city->meta_title")
@if (count($organizations) && $organizations->currentPage() > 1)
    @section('meta')
        <meta name="robots" content="noindex, follow">
    @endsection
@endif
@section('meta_description', "$city->meta_description")
@section('meta_keywords', "$city->meta_keywords")
@section('content')
    <section class="card-area section-padding">
        <div class="container pt-5">
            @if(count($organizations) > 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div
                            class="breadcrumb-content breadcrumb-content-2 d-flex flex-wrap align-items-end justify-content-between margin-bottom-30px">
                            <ul class="list-items bread-list bread-list-2 bg-transparent rounded-0 p-0 text-capitalize">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li>
                                    <a href="{{ route('category.wise.business',['state_slug' => $city->State->slug , 'organization_category_slug' => 'gym']) }}">{{ $city->State->name }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('city.wise.organizations', ['state_slug' => $city->State->slug, 'city_slug' => $city->slug, 'organization_category_slug' => 'gym']) }}">{{ $city->name }}</a>
                                </li>
                                <li>{{ $organizations[0]->organization_category }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="d-flex align-items-center pb-4 text-capitalize">
                            <h1 class="sec__title mb-0">
                                {{ ($organizations->onFirstPage() && $organization_category_count >= 10) ? 'Top 10 Best' : 'Best' }}
                                {{ Str::plural($organizations[0]->organization_category, $organization_category_count) }}
                                Near {{ $city->State->name }}, {{ $city->name }}
                            </h1>
                        </div>
                    </div>
                    @if($organizations->onFirstPage() && $organization_badge)
                        <div class="col-lg-12 nebraska-badge-div mobile">
                            <img class="nebraska-badge-image" src="{{ asset('images/badges/' . $organization_badge) }}"
                                 data-src="{{ asset('images/badges/' . $organization_badge) }}" alt="GymNearX Badge">
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
                                                <img
                                                    src="{{ asset('images/business/' . ($organization->organization_head_photo_file ?? 'default.jpg')) }}"
                                                    data-src="{{ asset('images/business/' . ($organization->organization_head_photo_file ?? 'default.jpg')) }}"
                                                    class="card__img lazy"
                                                    alt="{{ $organization->organization_name }}"
                                                    loading="lazy">
                                            </a>
                                        </div>
                                        <div class="card-content">
                                            <h2 class="card-title">
                                                <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}">{{ $organization->organization_name }}</a>
                                            </h2>
                                            <p class="card-sub">
                                                <a href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}">
                                                    <i class="la la-map-marker mr-1 text-color-5"></i>
                                                    @if ($organization->organization_address)
                                                        {{ str_replace('Address: ', '', $organization->organization_address) }}
                                                    @else
                                                        {{ ucfirst($organization->city->name ?? '') }}, {{ ucfirst($organization->State->name ?? '') }}, US
                                                    @endif
                                                </a>
                                            </p>
                                            <ul class="listing-meta d-flex align-items-center">
                                                @if($organization->rate_stars && $organization->reviews_total_count)
                                                    <li class="d-flex align-items-center">
                                                        <span
                                                            class="rate flex-shrink-0 font-size-17">{{ $organization->rate_stars }}</span>
                                                        <span class="rate-text font-size-17">{{ $organization->reviews_total_count }} Reviews</span>
                                                    </li>
                                                @endif
                                                <li>
                                                    <span class="price-range" data-toggle="tooltip" data-placement="top"
                                                          title="Pricey">
                                                        <strong
                                                            class="font-weight-medium">{{ $organization->price_policy ?? '$' }}</strong>
                                                    </span>
                                                </li>
                                                <li class="d-flex align-items-center font-size-17">
                                                    <i class="{{ $organization->category->icon }} mr-2 listing-icon"></i>&nbsp;&nbsp;
                                                    <p class="listing-business-category">{{ $organization->organization_category ?? $organization->category->name }}</p>
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

                            <div class="sidebar-widget">
                                <h3 class="widget-title text-capitalize">Other fitness centers
                                    near {{ $city->State->name . ','}} {{ $city->name }}</h3>
                                <div class="stroke-shape mb-4"></div>
                                <ul class="tag-list">
                                    @foreach($organization_categories as $category)
                                        @if($category->organization_category && $category->organization_category_slug != $organization_category_slug)
                                            <li>
                                                <a class="font-size-17" href="{{ route('city.wise.organizations', ['state_slug' => $category->State->slug, 'city_slug' => $category->city->slug, 'organization_category_slug' => $category->organization_category_slug]) }}">
                                                    {{ $category->organization_category }}
                                                    ({{ $category->category_count }})
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="sidebar-widget">
                                <h3 class="widget-title">Filter by City</h3>
                                <div class="stroke-shape mb-4"></div>
                                <div class="category-list">
                                    @foreach($cities->take(6) as $f_city)
                                        <a href="{{ route('city.wise.organizations', ['state_slug' => $f_city->State->slug, 'city_slug' => $f_city->slug, 'organization_category_slug' => 'gym']) }}"
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
                                            <a href="{{ route('city.wise.organizations', ['state_slug' => $f_city->State->slug, 'city_slug' => $f_city->slug, 'organization_category_slug' => 'gym']) }}"
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
                                    @if(count($cities) > 6)
                                        <a class="collapse-btn" data-toggle="collapse" href="#showMoreCity"
                                           role="button" aria-expanded="false" aria-controls="showMoreCity">
                                            <span class="collapse-btn-hide">Show More <i
                                                    class="la la-plus ml-1"></i></span>
                                            <span class="collapse-btn-show">Show Less <i
                                                    class="la la-minus ml-1"></i></span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="sidebar-widget">
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="w-40">
                                        <h3 class="widget-title">Filter by State</h3>
                                    </div>
                                    <div class="w-60">
                                        <input type="text" class="p-1 form-control" id="state_search"
                                               name="state_search" placeholder="Search State" autocomplete="off">
                                    </div>
                                </div>
                                <div class="stroke-shape mb-4"></div>
                                <div class="state-list">
                                    @foreach($states->take(5) as $state)
                                        <a href="{{ route('category.wise.business',['state_slug' => $state->slug , 'organization_category_slug' => 'gym']) }}"
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
                                            <a href="{{ route('category.wise.business',['state_slug' => $state->slug , 'organization_category_slug' => 'gym']) }}"
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

@section('js')
    <script>
        let searchStatesRoute = '{{ route('search-states') }}';
        let stateWiseOrganizationsRoute = "{{ route('category.wise.business', ['','']) }}";
        let assetPath = '{{ asset('images/sm-bg.jpg') }}';
    </script>
@endsection
