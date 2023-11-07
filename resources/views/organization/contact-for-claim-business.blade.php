@extends('layouts.master')
@section('title', "Gymnearx THE Local Business Directory | Contact for Claim Your Business")
@section('meta_description', "Gymnearx, best gym places in the USA")
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
                                    <a href="{{ route('claim.business', $organization->slug) }}">Claim Profile</a>
                                </li>
                                <li>
                                    Confirm Business Ownership
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <h1 class="card-header">Contact Us</h1>
                <div class="card-body text-dark">
                    <p class="card-text">Please contact us to confirm your ownership of <a
                            href="{{ route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]) }}">{{ $organization->organization_name }}</a>.
                        To help us confirm your business ownership as quick as possible, please upload a picture where
                        the signage of your business is clearly visible which maybe -</p>

                    <div class="pt-3">
                        <ul class="contact-for-claim-business-profile">
                            <li>Your store's front view</li>
                            <li>Sign on your office building</li>
                            <li>Your business card</li>
                            <li>A vehicle with your business logo</li>
                        </ul>
                    </div>

                    <form method="post" action="{{ route('store.contact.for.claim.business',$organization->slug) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group pt-3">
                            <label for="contact_email">Email address <span class="required">*</span></label>
                            <input type="email" class="form-control" name="contact_email" id="contact_email"
                                   aria-describedby="emailHelp" placeholder="Enter email" value="{{ old('contact_email') }}" required>
                        </div>

                        <div class="form-group pt-2">
                            <label for="contact_email">Phone number</label>
                            <input type="text" class="form-control" name="contact_number" id="contact_number"
                                   placeholder="Enter phone number" value="{{ old('contact_number') }}">
                        </div>

                        <div class="form-group pt-2">
                            <label for="editable_information">What business information you want to edit? <span
                                    class="required">*</span></label>
                            <textarea class="form-control" name="editable_information" id="editable_information"
                                      rows="3" required>{{ old('editable_information') }}</textarea>
                        </div>

                        <div>
                            <label for="validation_images">Photo</label>
                            <div class="custom-file padding-top-40px">
                                <input type="file" class="custom-file-input" name="validation_images[]"
                                       id="validation_images" multiple>
                                <label class="custom-file-label" for="validation_images">Choose file...</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning send-contact-button">Send</button>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(".custom-file-input").on("change", function () {
            let fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
