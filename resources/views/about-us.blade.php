@extends('layouts.master')
@section('title', "Gymnearx THE Local Business Directory | About Us")
@section('meta_description', "Gymnearx, best gym in the USA")
@section('content')
    <section>
        <div class="container main_container">
            <div class="padding-bottom-20px">
                <h1 class="text-center">About GymNearX: Your Fitness Destination</h1>
                <p class="padding-top-30px">Welcome to GymNearX, your ultimate fitness directory, designed to help you
                    discover the best gyms and fitness centers across the United States. Whether you're a seasoned
                    fitness enthusiast or just starting your wellness journey, GymNearX is your go-to resource for
                    locating the perfect fitness facility near you.</p>
            </div>

            <div class="padding-bottom-20px">
                <h1 class="text-center">Our Mission</h1>
                <p class="padding-top-30px">At GymNearX, our mission is to empower individuals across all states and
                    cities in the USA to take control of their health and well-being by making it easier than ever to
                    find the ideal fitness facility. We're dedicated to connecting fitness seekers with a diverse range
                    of gyms, fitness centers, and health clubs, making it simple to find the perfect fit for your unique
                    fitness goals.</p>
            </div>

            <div class="padding-bottom-20px">
                <h1 class="text-center pb-4">Why Choose GymNearX?</h1>
                <h3><strong>Comprehensive Listings:</strong></h3>
                <p class="padding-top-10px">GymNearX boasts an extensive database that covers all 50 states and
                    countless cities. We understand that fitness preferences are as diverse as our nation, so we're here
                    to help you find a gym that suits your lifestyle and objectives.</p>
            </div>

            <div class="padding-bottom-20px">
                <h3><strong>User-Friendly Interface:</strong></h3>
                <p class="padding-top-10px">Our website is designed with your convenience in mind. Simply enter your
                    location, and we'll provide you with a list of fitness facilities nearby, complete with essential
                    information to help you make an informed decision.</p>
            </div>

            <div class="padding-bottom-20px">
                <h3><strong>Detailed Gym Profiles:</strong></h3>
                <p class="padding-top-10px">GymNearX goes beyond basic listings. We provide detailed profiles for each
                    gym, including photos, descriptions, operating hours, services offered, and contact information.
                    This ensures you can evaluate your options thoroughly.</p>
            </div>

            <div class="padding-bottom-20px">
                <h3><strong>Reviews and Ratings:</strong></h3>
                <p class="padding-top-10px">We believe in the power of community feedback. Read reviews from real
                    gym-goers to gain insights into the quality and atmosphere of each facility. You can also leave your
                    own reviews to contribute to our fitness community.</p>
            </div>

            <div class="padding-bottom-20px">
                <h3><strong>Fitness Resources:</strong></h3>
                <p class="padding-top-10px">GymNearX isn't just a directory; it's a hub for fitness knowledge. Explore
                    our blog and articles to access valuable tips, workouts, and advice to enhance your fitness
                    journey.</p>
            </div>

            <div class="padding-bottom-20px">
                <h3><strong>Filter and Compare:</strong></h3>
                <p class="padding-top-10px">Use our filtering options to narrow down your search based on your
                    preferences, such as gym type, equipment, membership pricing, and more. You can even compare
                    multiple gyms side by side to make the best choice for your needs.</p>
            </div>

            <div class="padding-bottom-20px">
                <h1 class="text-center pb-4">Join the GymNearX Community</h1>
                <p class="padding-top-10px">Join the ever-growing GymNearX community and take your fitness journey to
                    the next level. We're passionate about helping you find the right fitness facility to match your
                    goals, lifestyle, and budget. Whether you're seeking a local gym for daily workouts, a yoga studio
                    for relaxation, or a state-of-the-art fitness center with a variety of amenities, GymNearX has you
                    covered.</p>
                <p class="padding-top-10px">GymNearX is more than just a directory; it's your partner in pursuing a
                    healthier, fitter you. Start exploring our listings today, and embark on your path to a better,
                    healthier lifestyle.</p>
            </div>

            <div class="padding-bottom-20px">
                <h1 class="text-center pb-4">Contact Us</h1>
                <p class="padding-top-10px">Have questions, feedback, or suggestions? We'd love to hear from you.
                    Contact us at <a
                        href="mailto:{{ config('app.support_mail') }}">{{ config('app.support_mail') }}</a> or <a
                        href="tel:{{ config('app.support_phone') }}">{{ config('app.support_phone') }}</a>, and our
                    dedicated team will be happy to assist you on your
                    fitness journey.</p>
                <p class="padding-top-10px">Choose GymNearX for a fitter, healthier you.</p>
            </div>
        </div>
    </section>
@endsection
