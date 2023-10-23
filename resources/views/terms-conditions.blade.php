@extends('layouts.master')
@section('title', "Gymnearx THE Local Business Directory | Terms & Conditions")
@section('meta_description', "Gymnearx, best gym in the USA")
@section('content')
    <section>
        <div class="container main_container">
            <div class="padding-bottom-20px">
                <h1 class="text-center">Terms and Conditions</h1>
                <p class="padding-top-30px">These Terms and Conditions ("Terms") govern your use of the GymNearX website
                    and services. Please read these Terms carefully before using our platform. By using GymNearX, you
                    agree to be bound by these Terms. If you do not agree with any part of these Terms, please do not
                    use our services.</p>
            </div>

            <div class="padding-bottom-20px text-justify">
                <h4>1. Acceptance of Terms</h4>
                <p class="padding-top-10px">By accessing or using GymNearX, you acknowledge that you have read,
                    understood, and agree to abide by these Terms. We reserve the right to modify or update these Terms
                    at any time without notice. It is your responsibility to review these Terms regularly to ensure you
                    are aware of any changes.</p>
            </div>

            <div class="padding-bottom-20px text-justify">
                <h4>2. Use of Services</h4>
                <p class="padding-top-10px"><strong>2.1 Eligibility:</strong> You must be at least 18 years old to use
                    GymNearX or have the consent of a legal guardian.</p>
                <p class="padding-top-10px"><strong>2.2 User Conduct:</strong> You agree not to engage in any activity
                    that may:</p>
                <p class="padding-top-10px">a. Violate any applicable laws or regulations.</p>
                <p class="padding-top-10px">b. Infringe upon the intellectual property rights of
                    GymNearX or any third party.</p>
                <p class="padding-top-10px">c. Interfere with or disrupt the operation of GymNearX or
                    the servers and networks connected to it.</p>
                <p class="padding-top-10px">d. Misuse, abuse, or attempt to gain unauthorized access to
                    GymNearX or any user's information.</p>
                <p class="padding-top-10px"><strong>2.3 User Reviews and Ratings:</strong> Users are welcome to leave
                    reviews and ratings on gym listings. Reviews must be accurate and not violate any of the conditions
                    outlined in section 2.2.</p>
            </div>

            <div class="padding-bottom-20px text-justify">
                <h4>3. Content and Intellectual Property</h4>
                <p class="padding-top-10px"><strong>3.1 Gym Listings:</strong> GymNearX may display information, images,
                    and content about gyms and fitness centers. This content is provided by the gyms themselves or other
                    users. GymNearX does not endorse or guarantee the accuracy of this information.</p>
                <p class="padding-top-10px"><strong>3.2 Intellectual Property:</strong> GymNearX and its logos, content,
                    and features are protected by intellectual property rights. You may not use our content, trademarks,
                    or any part of our services without explicit permission.</p>
            </div>

            <div class="padding-bottom-20px text-justify">
                <h4>4. Privacy</h4>
                <p class="padding-top-10px">Your use of GymNearX is also governed by our Privacy Policy, which outlines
                    how we collect, use, and share your personal information. By using GymNearX, you consent to our data
                    practices as outlined in our Privacy Policy.</p>
            </div>

            <div class="padding-bottom-20px text-justify">
                <h4>5. Liability and Disclaimers</h4>
                <p class="padding-top-10px"><strong>5.1 Accuracy of Information:</strong> While GymNearX strives to
                    provide accurate and up-to-date information, we do not guarantee the accuracy of the information
                    provided by gyms or users on our platform. Users should independently verify the information before
                    making any decisions.</p>
                <p class="padding-top-10px"><strong>5.2 No Endorsement:</strong> GymNearX does not endorse or recommend
                    any specific gym, fitness center, or service listed on our platform. Your choice to use any gym is
                    entirely at your discretion.</p>
                <p class="padding-top-10px"><strong>5.3 Limitation of Liability: </strong> GymNearX is not responsible
                    for any damages, losses, or claims resulting from your use of the platform or reliance on the
                    information provided.</p>
            </div>

            <div class="padding-bottom-20px text-justify">
                <h4>6. Termination</h4>
                <p class="padding-top-10px">We reserve the right to terminate or suspend your access to GymNearX at our
                    discretion, without notice, for any violation of these Terms or for any other reason.</p>
            </div>

            <div class="padding-bottom-20px text-justify">
                <h4>7. Contact Information</h4>
                <p class="padding-top-10px">If you have any questions or concerns about these Terms, please contact us
                    at <a
                        href="mailto:{{ config('app.support_mail') }}">{{ config('app.support_mail') }}</a> or <a
                        href="tel:{{ config('app.support_phone') }}">{{ config('app.support_phone') }}</a>.
                </p>
                <p class="padding-top-10px">By using GymNearX, you agree to these Terms and Conditions and our Privacy Policy. Thank you for using GymNearX as your fitness directory.</p>
            </div>
        </div>
    </section>
@endsection
