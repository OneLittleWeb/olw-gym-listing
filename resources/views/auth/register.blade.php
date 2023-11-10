@extends('layouts.master')
@section('title', "Register - GymNearX")
@section('meta_description', "To be added")
@php $cities = \App\Models\City::all(); $city = null; @endphp
@section('content')
    <section class="contact-area section-padding position-relative">
        <span class="circle-bg circle-bg-1 position-absolute"></span>
        <span class="circle-bg circle-bg-2 position-absolute"></span>
        <span class="circle-bg circle-bg-3 position-absolute"></span>
        <span class="circle-bg circle-bg-4 position-absolute"></span>
        <span class="circle-bg circle-bg-5 position-absolute"></span>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-7">
                    <div class="block-card">
                        <div class="block-card-header">
                            <h1 class="widget-title pb-0">Register Now</h1>
                            <p class="pt-1">In order to manage your listings later, we suggest that you create an
                                account with us. Already have an account? <a href="{{route('login')}}">Click here to
                                    login </a></p>
                        </div>
                        @if(!$errors->isEmpty())
                            <div class="alert alert-red text-danger">
                                <ul class="list-unstyled">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" class="form-box row">
                            <form class="form-box row" action="{{route('register')}}" method="POST">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="input-box">
                                        <label class="label-text">Your Name</label>
                                        <div class="form-group">
                                            <span class="la la-user form-icon"></span>
                                            <input class="form-control form-control-styled" type="text" id="name"
                                                   name="name" placeholder="Your Name" value="{{old('name')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-box">
                                        <label class="label-text">Your Email</label>
                                        <div class="form-group">
                                            <span class="la la-envelope-o form-icon"></span>
                                            <input class="form-control form-control-styled" type="email" name="email"
                                                   placeholder="Your Email" value="{{old('email')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-box">
                                        <label class="label-text">Password</label>
                                        <div class="form-group">
                                            <span class="la la-lock form-icon"></span>
                                            <input class="form-control form-control-styled" type="password"
                                                   name="password"
                                                   placeholder="Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="input-box">
                                        <label class="label-text">Confirm Password</label>
                                        <div class="form-group">
                                            <span class="la la-lock form-icon"></span>
                                            <input class="form-control form-control-styled" type="password"
                                                   id="password_confirmation"
                                                   placeholder="Confirm Password" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="btn-box">
                                        <button type="submit" class="theme-btn gradient-btn border-0">Register <i
                                                class="la la-arrow-right ml-1"></i></button>
                                        <p class="font-size-14 pt-1">*We'll never share your email with anyone else.</p>
                                    </div>
                                </div>
                            </form>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
