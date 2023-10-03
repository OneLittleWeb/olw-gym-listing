@extends('layouts.master')
@section('title', "Checkout - Nebraskalisting")
@section('meta_description', "To be added")
@section('content')
    <section>
        <div class="container main_container">
            <h1 class="text-center">Check Out</h1>
            <div class="container my-4">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{  $error }}</li>
                                    @endforeach
                                </ul>
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                <ul>
                                    @foreach (session()->get('success') as $message)
                                        <li>{{  $message }}</li>
                                    @endforeach
                                </ul>
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="post" action="{{ route('payment.checkout') }}" id="paymentForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="card-holder-name" name="name"
                                           value="{{ auth()->user()->name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ auth()->user()->email }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Street, PO Box, Or Company Name</label>
                                    <input type="text" class="form-control" id="line1" name="line1"
                                           value="{{ auth()->user()->line1 }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Apartment, Suite, Unit, or Building</label>
                                  <input type="text" class="form-control" id="line2" name="line2"
                                           value="{{ auth()->user()->line2 }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">State</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                           value="{{ auth()->user()->state }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                           value="{{ auth()->user()->city }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                           value="{{ auth()->user()->country }}" required>
                                </div>
                                 <div class="col-md-6">
                                    <label for="email" class="form-label">Post Code/Zip</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code"
                                           value="{{ auth()->user()->postal_code }}" required>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Plans</label>
                                    <select name="currency" id="currency" class="form-control">
                                        @foreach($plans as $plan)
                                            <option
                                                value="{{$plan->id}}" {{$plan->id == optional($selected_plan)->id ? 'selected' : ''}}>{{strtoupper($plan->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Pay</label>
                                    <input type="number" class="form-control" id="value" name="value"
                                           value="{{ optional($selected_plan)->price }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Currencies</label>
                                    <select name="currency" id="currency" class="form-control">
                                        @foreach($currencies as $currency)
                                            <option
                                                value="{{$currency->iso}}" {{$currency->iso == "usd" ? 'selected' : ''}}>{{strtoupper($currency->iso)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 pt-4">
                                    <label for="message" class="form-label">Select Desired Payment Platform</label>
                                    <div class="form-group" id="toggler">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            @foreach($platforms as $platform)
                                                <label class="btn btn-outline-secondary rounded m-2 p-1"
                                                       data-target="#{{$platform->name}}Collapse"
                                                       data-toggle="collapse">
                                                    <input type="radio" name="platform" value="{{$platform->id}}"
                                                           required> <img src="{{asset($platform->image)}}" width="100">
                                                </label>
                                            @endforeach
                                        </div>
                                        @foreach($platforms as $platform)
                                            <div id="{{$platform->name}}Collapse" class="collapse"
                                                 data-parent="#toggler">
                                                @includeIf('partials.'.strtolower($platform->name).'-collapse')
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-12 pt-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" data-secret="{{ $intent->client_secret }}"
                                                    class="btn btn-dark w-100 fw-bold" id="payButton">Send
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

