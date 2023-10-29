@extends('admin.master_admin')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid dashboard-inner-body-container">
        <div class="breadcrumb-content d-sm-flex align-items-center justify-content-between mb-4">
            <div class="section-heading">
                <h2 class="sec__title font-size-24 mb-0">DashBoard</h2>
            </div>
            <ul class="list-items bread-list bread-list-2">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li>Dashboard</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card-item dashboard-stat">
                    <div class="card-content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="card-title font-size-40">{{ number_format($organization_count, 0, '.', ',') }}</h2>
                                <p class="card-sub font-size-18 line-height-24">Active Listings</p>
                            </div>
                            <div class="col-auto font-size-60">
                                <i class="la la-map-marked text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card-item dashboard-stat">
                    <div class="card-content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="card-title font-size-40">{{ number_format($reviews_count, 0, '.', ',') }}</h2>
                                <p class="card-sub font-size-18 line-height-24">Total Reviews</p>
                            </div>
                            <div class="col-auto font-size-60">
                                <i class="la la-star-o text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card-item dashboard-stat">
                    <div class="card-content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="card-title font-size-40">{{ $state_count }}</h2>
                                <p class="card-sub font-size-18 line-height-24">Total States</p>
                            </div>
                            <div class="col-auto font-size-60">
                                <i class="la la-line-chart text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card-item dashboard-stat">
                    <div class="card-content">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="card-title font-size-40">{{ $city_count }}</h2>
                                <p class="card-sub font-size-18 line-height-24">Total City</p>
                            </div>
                            <div class="col-auto font-size-60">
                                <i class="la la-bookmark text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--            <div class="col-lg-7">--}}
            {{--                <div class="block-card dashboard-card mb-4 px-0">--}}
            {{--                    <div--}}
            {{--                        class="block-card-header d-flex flex-wrap align-items-center justify-content-between px-4 border-bottom-0 pb-0">--}}
            {{--                        <h2 class="widget-title pb-0">Invoices</h2>--}}
            {{--                        <a href="#" class="btn-gray">View More <i class="la la-arrow-right ml-1"></i></a>--}}
            {{--                    </div>--}}
            {{--                    <div class="block-card-body">--}}
            {{--                        <div class="my-table table-responsive">--}}
            {{--                            <table class="table align-items-center table-flush mb-0">--}}
            {{--                                <thead class="thead-light">--}}
            {{--                                <tr>--}}
            {{--                                    <th>Order ID</th>--}}
            {{--                                    <th>Customer</th>--}}
            {{--                                    <th>Item</th>--}}
            {{--                                    <th>Date</th>--}}
            {{--                                    <th>Status</th>--}}
            {{--                                    <th>Action</th>--}}
            {{--                                </tr>--}}
            {{--                                </thead>--}}
            {{--                                <tbody>--}}
            {{--                                <tr>--}}
            {{--                                    <td><a href="#" class="order-id">RA0449</a></td>--}}
            {{--                                    <td>Udin Wayang</td>--}}
            {{--                                    <td>Nasi Padang</td>--}}
            {{--                                    <td>20/02/2020</td>--}}
            {{--                                    <td><span class="badge badge-success">Paid</span></td>--}}
            {{--                                    <td><a href="#" class="btn btn-sm theme-btn-primary">Invoice</a>--}}
            {{--                                    </td>--}}
            {{--                                </tr>--}}
            {{--                                <tr>--}}
            {{--                                    <td><a href="#" class="order-id">RA5324</a></td>--}}
            {{--                                    <td>Jaenab Bajigur</td>--}}
            {{--                                    <td>Gundam 90' Edition</td>--}}
            {{--                                    <td>20/02/2020</td>--}}
            {{--                                    <td><span class="badge badge-warning text-white">Shipping</span></td>--}}
            {{--                                    <td><a href="#" class="btn btn-sm theme-btn-primary">Invoice</a>--}}
            {{--                                    </td>--}}
            {{--                                </tr>--}}
            {{--                                </tbody>--}}
            {{--                            </table>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="col-lg-5">--}}
            {{--                <div class="block-card dashboard-card mb-4 px-0 pb-0">--}}
            {{--                    <div class="block-card-header px-4">--}}
            {{--                        <h2 class="widget-title pb-0">Message From Customer</h2>--}}
            {{--                    </div>--}}
            {{--                    <div class="block-card-body pt-0">--}}
            {{--                        <div class="generic-list msg-from-customer">--}}
            {{--                            <a class="generic-list-item d-flex align-items-center"--}}
            {{--                               href="#">--}}
            {{--                                <div class="user-thumb user-thumb-sm flex-shrink-0 position-relative">--}}
            {{--                                    <img src="images/avatar-img.jpg" alt="author-image">--}}
            {{--                                    <div class="status-indicator bg-success"></div>--}}
            {{--                                </div>--}}
            {{--                                <div class="ml-2">--}}
            {{--                                    <p class="text-truncate text-color font-size-14 font-weight-medium">Hi--}}
            {{--                                        there! I am wondering if you can help me with a problem I've been--}}
            {{--                                        having.</p>--}}
            {{--                                    <p class="small text-gray">Udin Cilok · 1m</p>--}}
            {{--                                </div>--}}
            {{--                            </a>--}}
            {{--                            <a class="generic-list-item d-flex align-items-center"--}}
            {{--                               href="#">--}}
            {{--                                <div class="user-thumb user-thumb-sm flex-shrink-0 position-relative">--}}
            {{--                                    <img src="images/avatar-img2.jpg" alt="author-image">--}}
            {{--                                    <div class="status-indicator"></div>--}}
            {{--                                </div>--}}
            {{--                                <div class="ml-2">--}}
            {{--                                    <p class="text-truncate text-color font-size-14 font-weight-medium">Am I a--}}
            {{--                                        good boy? The reason I ask is because someone told me that people say--}}
            {{--                                        this to all dogs, even if they aren't good</p>--}}
            {{--                                    <p class="small text-gray">Joynal Ali · 4m</p>--}}
            {{--                                </div>--}}
            {{--                            </a>--}}
            {{--                            <a class="dropdown-item text-center small text-gray font-weight-medium py-2"--}}
            {{--                               href="#">View More <i--}}
            {{--                                    class="la la-arrow-right ml-1"></i></a>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </div>
@endsection
