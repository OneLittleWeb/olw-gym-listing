@extends('layouts.master')
@section('title', "Nebraskalisting THE Local Business Directory | Contact Us")
@section('meta_description', "nebraskalisting, best places in nebraska")
@section('content')
    <section>
        <div class="container main_container">
            <h1 class="text-center">Contact US</h1>
            <div class="container my-4">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <form method="post" action="{{ route('contact.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Your Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Your Email <span class="required">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                                <div class="col-md-6 pt-4">
                                    <label for="subject" class="form-label">Your Subject <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}" required>
                                </div>
                                <div class="col-md-6 pt-4">
                                    <label for="subject" class="form-label">Your Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                                </div>
                                <div class="col-12 pt-4">
                                    <label for="message" class="form-label">Your Message <span class="required">*</span></label>
                                    <textarea class="form-control" id="message" name="message" rows="5"
                                              required>{{ old('message') }}</textarea>
                                </div>
                                <div class="col-12 pt-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit"
                                                    class="btn btn-dark w-100 fw-bold">Send
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
