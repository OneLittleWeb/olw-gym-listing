@extends('layouts.master')
@section('title', "THE Local Business Directory | 404-Not Found")
@section('meta_description', "404 Not Found - GymNearX")
@section('content')
    <section class="error-area section-padding position-relative mt-5">
        <span class="circle-bg circle-bg-1 position-absolute"></span>
        <span class="circle-bg circle-bg-2 position-absolute"></span>
        <span class="circle-bg circle-bg-3 position-absolute"></span>
        <span class="circle-bg circle-bg-4 position-absolute"></span>
        <span class="circle-bg circle-bg-5 position-absolute"></span>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="error-content text-center">
                        <h1 class="display-1 fw-bold">404</h1>
                        <div class="section-heading padding-top-30px">
                            <h3 class="sec__title"><span class="text-danger">Oops!</span> That page can’t be found.</h3>
                            <p class="sec__desc">
                                The page you are looking for might have been removed or is temporarily unavailable.
                            </p>
                        </div>
                        <div class="btn-box pt-4">
                            <a href="{{ route('home') }}" class="theme-btn gradient-btn"><i class="la la-mail-reply mr-2"></i> Back to Home</a>
                        </div>
                    </div><!-- end error-content -->
                </div><!-- end col-lg-6 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section><!-- end error-area -->
@endsection
