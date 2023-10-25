@extends('layouts.master')
@section('title', "Gymnearx THE Local Business Directory | Privacy Policy")
@section('meta_description', "Gymnearx, best gym in the USA")
@section('content')
    <section>
        <div class="container main_container">
            <div class="padding-bottom-20px">
                <h1 class="text-center">Privacy Policy</h1>
                <p class="padding-top-30px">GymNearX ("we," "our," or "us") is committed to protecting the privacy of
                    our users. This Privacy Policy outlines how we collect, use, and protect your personal information
                    when you use our website and services. By using GymNearX, you agree to the practices described in
                    this policy.</p>
            </div>

            <div class="padding-bottom-20px">
                <h2><strong>Information We Collect</strong></h2>
                <p class="padding-top-10px"><strong>1. Personal Information:</strong> When you use GymNearX, we may
                    collect personal information such as your name, email address, and contact details.</p>
                <p class="padding-top-10px"><strong>2. Usage Data:</strong> We automatically collect information about
                    your use of GymNearX, including your IP address, device information, browser type, and the pages you
                    visit.</p>
                <p class="padding-top-10px"><strong>3. User-Generated Content:</strong> We collect any content you post
                    on our platform, such as gym reviews and ratings.</p>
            </div>

            <div class="padding-bottom-20px">
                <h2><strong>How We Use Your Information</strong></h2>
                <p class="padding-top-10px">We use your information for the following purposes:</p>
                <p class="padding-top-10px"><strong>1. Providing Services:</strong> We use your information to operate
                    and maintain GymNearX, including displaying gym listings, user reviews, and ratings.</p>
                <p class="padding-top-10px"><strong>2. Communication:</strong> We may use your contact information to
                    respond to your inquiries, send important updates, or provide support.</p>
                <p class="padding-top-10px"><strong>3. Improvement:</strong> Your information helps us understand how
                    users interact with GymNearX, enabling us to improve our platform and services.</p>
            </div>

            <div class="padding-bottom-20px">
                <h2><strong>Sharing Your Information</strong></h2>
                <p class="padding-top-10px">We do not sell, trade, or rent your personal information to third parties.
                    We may share your information in the following situations:</p>
                <p class="padding-top-10px"><strong>1. Consent:</strong> When you provide us with explicit consent to
                    share your information.</p>
                <p class="padding-top-10px"><strong>2. Service Providers:</strong> We may share your information with
                    third-party service providers who help us operate GymNearX, such as hosting, analytics, and customer
                    support.</p>
                <p class="padding-top-10px"><strong>3. Legal Compliance:</strong> If required by law or in response to
                    legal requests or government authorities, we may disclose your information.</p>
            </div>

            <div class="padding-bottom-20px">
                <h2><strong>Your Choices</strong></h2>
                <p class="padding-top-10px">You can manage your information and privacy preferences in the following
                    ways:</p>
                <p class="padding-top-10px"><strong>1. Access and Correction: </strong> You may access and update your
                    personal information in your account settings.</p>
                <p class="padding-top-10px"><strong>2. Unsubscribe:</strong> You can unsubscribe from our email
                    communications by following the instructions in the email.</p>
                <p class="padding-top-10px"><strong>3. Deletion:</strong> You may request the deletion of your account
                    and associated information by contacting us.</p>
            </div>

            <div class="padding-bottom-20px">
                <h2><strong>Security</strong></h2>
                <p class="padding-top-10px">We take appropriate security measures to protect your information from
                    unauthorized access, disclosure, alteration, or destruction. However, no method of transmission over
                    the internet or electronic storage is entirely secure. While we strive to protect your information,
                    we cannot guarantee its absolute security.</p>
            </div>

            <div class="padding-bottom-20px">
                <h2><strong>Children's Privacy</strong></h2>
                <p class="padding-top-10px">GymNearX is not intended for individuals under the age of 18. We do not
                    knowingly collect personal information from children. If you believe that a child has provided us
                    with their personal information, please contact us, and we will take appropriate steps to remove
                    this information.</p>
            </div>

            <div class="padding-bottom-20px">
                <h2><strong>Changes to this Privacy Policy</strong></h2>
                <p class="padding-top-10px">We may update this Privacy Policy from time to time. Any changes will be
                    posted on this page with an updated effective date. Please review this Privacy Policy regularly to
                    stay informed about our data practices.</p>
            </div>

            <div class="padding-bottom-20px text-justify">
                <h4>Contact Us</h4>
                <p class="padding-top-10px">If you have questions or concerns about this Privacy Policy or your personal
                    information, please contact us at <a
                        href="mailto:{{ config('app.support_mail') }}">{{ config('app.support_mail') }}</a> or <a
                        href="tel:{{ config('app.support_phone') }}">{{ config('app.support_phone') }}</a>.
                </p>
                <p class="padding-top-10px">By using GymNearX, you agree to these <a href="{{ route('terms.conditions') }}">Terms and Conditions</a> and our Privacy
                    Policy. Thank you for using GymNearX as your fitness directory.</p>
            </div>

        </div>
    </section>
@endsection
