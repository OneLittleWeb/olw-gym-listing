@extends('layouts.master')
@section('title', "Pricing - Nebraskalisting")
@section('meta_description', "To be added")
@section('content')
    <section class="category-area section--padding margin-top-40px">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 responsive-column">
                    <div class="price-item">
                        <div class="price-head bg-1">
                            <h3 class="price__title text-uppercase">Free</h3>
                            <svg class="svg-bg h-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10"
                                 preserveAspectRatio="none">
                                <path fill="#fff" d="M0 10 0 0 A 90 59, 0, 0, 0, 100 0 L 100 10 Z"></path>
                            </svg>
                        </div><!-- end price-head -->
                        <div
                            class="price-box d-flex flex-column align-items-center justify-content-center mx-auto text-color-3">
                            <h3 class="price__text text-color-3">0</h3>
                            <span class="price__text-meta">/month</span>
                        </div><!-- end price-box -->
                        <ul class="list-items price-list mt-4">
                            <li><i class="la la-check text-success mr-2"></i>One Listing</li>
                            <li><i class="la la-check text-success mr-2"></i>10 Days Availability</li>
                            <li><i class="la la-check text-success mr-2"></i>2 Tags Per Listing</li>
                            <li><i class="la la-check text-success mr-2"></i>Non-Featured</li>
                            <li><i class="la la-check text-success mr-2"></i>Limited Support</li>
                            <li><i class="la la-close text-danger mr-2"></i>Average Price Range</li>
                            <li><i class="la la-close text-danger mr-2"></i>Business Hours</li>
                            <li><i class="la la-close text-danger mr-2"></i>Lifetime Availability</li>
                            <li><i class="la la-close text-danger mr-2"></i>Featured In Search Results</li>
                        </ul>
                        <div class="price-btn-box text-center">
                            <a href="add-listing.html" class="theme-btn bg-1 text-white">Get Started <i
                                    class="la la-arrow-right ml-2"></i></a>
                        </div>
                    </div><!-- end price-item -->
                </div><!-- end col-lg-4 -->
                @foreach($plans as $plan)
                    <div class="col-lg-4 responsive-column">
                        <div class="price-item">
                            <div class="price-head bg-2">
                                <span class="ribbon ribbon-2">Most Popular</span>
                                <h3 class="price__title text-uppercase">{{$plan->name}}</h3>
                                <svg class="svg-bg h-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10"
                                     preserveAspectRatio="none">
                                    <path fill="#fff" d="M0 10 0 0 A 90 59, 0, 0, 0, 100 0 L 100 10 Z"></path>
                                </svg>
                            </div><!-- end price-head -->
                            <div
                                class="price-box d-flex flex-column align-items-center justify-content-center mx-auto text-color-4">
                                <h3 class="price__text text-color-4">{{$plan->price}}</h3>
                                <span class="price__text-meta">{{$plan->abbreviation}}</span>
                            </div><!-- end price-box -->
                            <ul class="list-items price-list mt-4">
                                @if(!is_null($plan->included))
                                    @foreach(json_decode($plan->included) as $included)
                                        <li><i class="la la-check text-success mr-2"></i>{{$included}}</li>
                                    @endforeach
                                @endif
                                @if(!is_null($plan->not_included))
                                    @foreach(json_decode($plan->not_included) as $notincluded)
                                        <li><i class="la la-close text-danger mr-2"></i>{{$notincluded}}</li>
                                    @endforeach
                                @endif
                            </ul>
                            <div class="price-btn-box text-center">
                                <a href="{{route('payment.form',['plan' => $plan->slug])}}" class="theme-btn bg-2 text-white">Get Started <i
                                        class="la la-arrow-right ml-2"></i></a>
                            </div>
                        </div><!-- end price-item -->
                    </div><!-- end col-lg-4 -->
                @endforeach

            </div><!-- end row -->
        </div><!-- end container -->
    </section>
@endsection
