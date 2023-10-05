<section class="footer-area bg-gradient-gray pattern-bg-2 padding-top-30px padding-bottom-30px">
    <div class="container">
        <div class="margin-top-30px margin-bottom-30px"></div>
        <div class="row">
            <div class="col-lg-3 responsive-column">
                <div class="footer-item">
                    <div class="footer-logo">
                        <a href="{{ route('home') }}" class="foot-logo"><img
                                src="{{asset('/images/logo-black.png')}}"
                                alt="logo"></a>
                    </div>
                    <ul class="list-items contact-links pt-3">
                        <li><span class="d-block text-color mb-1"><i
                                    class="la la-phone mr-1 text-color-2"></i>Phone:</span><a href="tel:{{ config('app.support_phone') }}">{{ config('app.support_phone') }}</a></li>
                        <li><span class="d-block text-color mb-1"><i class="la la-envelope mr-1 text-color-2"></i>Email:</span><a
                                href="mailto:{{ config('app.support_mail') }}">{{ config('app.support_mail') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 responsive-column">
                <div class="footer-item">
                    <h4 class="footer__title">Company</h4>
                    <div class="stroke-shape mb-3"></div>
                    <ul class="list-items">
                        <li><a href="{{ route('page.about') }}">About Us</a></li>
                        <li><a href="{{ route('page.contact') }}">Contact Us</a></li>
                        <li><a href="{{ route('terms.conditions') }}">Terms & Conditions</a></li>
                        <li><a href="{{ route('page.privacy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 responsive-column">
                <div class="footer-item">
                    <h4 class="footer__title">Discover</h4>
                    <div class="stroke-shape mb-3"></div>
                    <ul class="list-items">
                        <li><a href="/blog">{{ config('app.name') }} Blog</a></li>
                        <li><a href="{{ route('page.contact') }}">Support</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 responsive-column">
                <div class="footer-item">
                    <h4 class="footer__title">{{ config('app.name') }} for Business</h4>
                    <div class="stroke-shape mb-3"></div>
                    <ul class="list-items">
                        <li><a href="{{ route('login') }}">Claim your Business</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-lg-12">
                <div class="cta-content d-flex align-items-center justify-content-between p-0">
                    <div class="section-heading">
                        <h2 class="sec__title mb-0 font-size-24 line-height-30">Don't miss any update!</h2>
                        <p class="sec__desc font-size-16">Subscribe to get latest updates and information.</p>
                    </div>
                    <form action="#" class="form-box">
                        <div class="form-group mb-0">
                            <span class="la la-envelope-o form-icon"></span>
                            <input class="form-control form-control-styled form-control-long" type="email"
                                   placeholder="Enter your email">
                            <p class="font-size-12 font-weight-medium pt-1"><i class="la la-lock mr-1"></i>Your are 100%
                                protected</p>
                            <button class="theme-btn gradient-btn subscribe-btn input-btn-append border-0"
                                    type="submit">Subscribe <i class="la la-arrow-right ml-1"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="section-block-2 margin-top-30px margin-bottom-30px"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="copy-right text-center">
                    <p class="copy__desc">
                        &copy; <script> document.write(new Date().getFullYear()); </script> Copyright {{ config('app.name') }}. All Rights Reserved
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- start back-to-top -->
<div id="back-to-top">
    <i class="la la-arrow-up" title="Go top"></i>
</div>
<!-- end back-to-top -->
