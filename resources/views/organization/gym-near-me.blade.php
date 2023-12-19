@extends('layouts.master')
@section('title', config('app.name') . " THE Local Business Directory | States")
@section('meta_description', "Browse near by all gyms.")
@section('meta_keywords',"USA, gymnearx, gymnearme")
@section('content')

    <!-- ================================
    START BREADCRUMB AREA
================================= -->
    <section class="breadcrumb-area bg-gradient-gray py-4">
        <div class="container-fluid padding-right-40px padding-left-40px slide-image-top">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
                        <div class="section-heading text-capitalize">
                            @if($organizations)
                                <h2 class="sec__title font-size-26 mb-0">{{ $organizations[0]->organization_category }}
                                    near {{ $organizations[0]->city->name }}</h2>
                            @else
                                <h2 class="sec__title font-size-26 mb-0">Find a gym near you</h2>
                            @endif
                        </div>
                        <ul class="list-items bread-list bread-list-2 text-capitalize">
                            <li><a href="#">Home</a></li>
                            @if($organizations)
                                <li>{{ $organizations[0]->organization_category }}
                                    near {{ $organizations[0]->city->name }}</li
                            @else
                                <li>Find a gym near you</li>
                            @endif
                        </ul>
                    </div><!-- end breadcrumb-content -->
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end container-fluid -->
    </section><!-- end breadcrumb-area -->
    <!-- ================================
        END BREADCRUMB AREA
    ================================= -->

    <!-- ================================
       START FULL SCREEN AREA
================================= -->
    <section class="full-screen-container d-flex">
        <div class="w-30 card-area">
            <div class="filter-bar-wrap padding-left-30px padding-right-30px">
                <div
                    class="filter-bar d-flex flex-wrap justify-content-between align-items-center shadow-none rounded-0 border-0 px-0">
                    <p class="result-text font-weight-medium">Showing 1 to 6 of {{ $organizations->count() }} locations</p>
                    <div class="filter-bar-action d-flex flex-wrap align-items-center">
                        <div class="user-chosen-select-container ml-3">
                            <select class="user-chosen-select">
                                <option value="sort-by-default">Sort by default</option>
                                <option value="high-rated">High Rated</option>
                                <option value="most-reviewed">Most Reviewed</option>
                                <option value="popular-Listing">Popular Listing</option>
                                <option value="newest-Listing">Newest Listing</option>
                                <option value="older-Listing">Older Listing</option>
                                <option value="price-low-to-high">Price: low to high</option>
                                <option value="price-high-to-low">Price: high to low</option>
                                <option value="all-listings">Random</option>
                            </select>
                        </div>
                        <ul class="filter-nav ml-1">
                            <li><a href="listing-grid.html" data-toggle="tooltip" data-placement="top" title="Grid View"
                                   class="active"><span class="la la-th-large"></span></a></li>
                            <li><a href="listing-list.html" data-toggle="tooltip" data-placement="top"
                                   title="List View"><span class="la la-list"></span></a></li>
                        </ul>
                    </div><!-- end filter-bar-action -->
                </div><!-- end filter-bar -->
                <div class="section-block"></div>
                <form method="post" class="form-box row py-4">
                    <div class="col-lg-6 input-box">
                        <label class="label-text">Keywords</label>
                        <div class="form-group">
                            <span class="la la-search form-icon"></span>
                            <input class="form-control" type="search" name="text"
                                   placeholder="What are you looking for?">
                        </div>
                    </div>
                    <div class="col-lg-6 input-box">
                        <label class="label-text">Where to look?</label>
                        <div class="form-group user-chosen-select-container">
                            <select class="user-chosen-select">
                                <option value="0">Select a Location</option>
                                <option value="AF">Afghanistan</option>
                                <option value="AX">Åland Islands</option>
                                <option value="AL">Albania</option>
                                <option value="DZ">Algeria</option>
                                <option value="AD">Andorra</option>
                                <option value="AO">Angola</option>
                                <option value="AI">Anguilla</option>
                                <option value="AQ">Antarctica</option>
                                <option value="AG">Antigua &amp; Barbuda</option>
                                <option value="AR">Argentina</option>
                                <option value="AM">Armenia</option>
                                <option value="AW">Aruba</option>
                                <option value="AC">Ascension Island</option>
                                <option value="AU">Australia</option>
                                <option value="AT">Austria</option>
                                <option value="AZ">Azerbaijan</option>
                                <option value="BS">Bahamas</option>
                                <option value="BH">Bahrain</option>
                                <option value="BD">Bangladesh</option>
                                <option value="BB">Barbados</option>
                                <option value="BY">Belarus</option>
                                <option value="BE">Belgium</option>
                                <option value="BZ">Belize</option>
                                <option value="BJ">Benin</option>
                                <option value="BM">Bermuda</option>
                                <option value="BT">Bhutan</option>
                                <option value="BO">Bolivia</option>
                                <option value="BA">Bosnia &amp; Herzegovina</option>
                                <option value="BW">Botswana</option>
                                <option value="BV">Bouvet Island</option>
                                <option value="BR">Brazil</option>
                                <option value="IO">British Indian Ocean Territory</option>
                                <option value="VG">British Virgin Islands</option>
                                <option value="BN">Brunei</option>
                                <option value="BG">Bulgaria</option>
                                <option value="BF">Burkina Faso</option>
                                <option value="BI">Burundi</option>
                                <option value="KH">Cambodia</option>
                                <option value="CM">Cameroon</option>
                                <option value="CA">Canada</option>
                                <option value="CV">Cape Verde</option>
                                <option value="BQ">Caribbean Netherlands</option>
                                <option value="KY">Cayman Islands</option>
                                <option value="CF">Central African Republic</option>
                                <option value="TD">Chad</option>
                                <option value="CL">Chile</option>
                                <option value="CN">China</option>
                                <option value="CO">Colombia</option>
                                <option value="KM">Comoros</option>
                                <option value="CG">Congo - Brazzaville</option>
                                <option value="CD">Congo - Kinshasa</option>
                                <option value="CK">Cook Islands</option>
                                <option value="CR">Costa Rica</option>
                                <option value="CI">Côte d’Ivoire</option>
                                <option value="HR">Croatia</option>
                                <option value="CW">Curaçao</option>
                                <option value="CY">Cyprus</option>
                                <option value="CZ">Czechia</option>
                                <option value="DK">Denmark</option>
                                <option value="DJ">Djibouti</option>
                                <option value="DM">Dominica</option>
                                <option value="DO">Dominican Republic</option>
                                <option value="EC">Ecuador</option>
                                <option value="EG">Egypt</option>
                                <option value="SV">El Salvador</option>
                                <option value="GQ">Equatorial Guinea</option>
                                <option value="ER">Eritrea</option>
                                <option value="EE">Estonia</option>
                                <option value="SZ">Eswatini</option>
                                <option value="ET">Ethiopia</option>
                                <option value="FK">Falkland Islands</option>
                                <option value="FO">Faroe Islands</option>
                                <option value="FJ">Fiji</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="GF">French Guiana</option>
                                <option value="PF">French Polynesia</option>
                                <option value="TF">French Southern Territories</option>
                                <option value="GA">Gabon</option>
                                <option value="GM">Gambia</option>
                                <option value="GE">Georgia</option>
                                <option value="DE">Germany</option>
                                <option value="GH">Ghana</option>
                                <option value="GI">Gibraltar</option>
                                <option value="GR">Greece</option>
                                <option value="GL">Greenland</option>
                                <option value="GD">Grenada</option>
                                <option value="GP">Guadeloupe</option>
                                <option value="GU">Guam</option>
                                <option value="GT">Guatemala</option>
                                <option value="GG">Guernsey</option>
                                <option value="GN">Guinea</option>
                                <option value="GW">Guinea-Bissau</option>
                                <option value="GY">Guyana</option>
                                <option value="HT">Haiti</option>
                                <option value="HN">Honduras</option>
                                <option value="HK">Hong Kong SAR China</option>
                                <option value="HU">Hungary</option>
                                <option value="IS">Iceland</option>
                                <option value="IN">India</option>
                                <option value="ID">Indonesia</option>
                                <option value="IR">Iran</option>
                                <option value="IQ">Iraq</option>
                                <option value="IE">Ireland</option>
                                <option value="IM">Isle of Man</option>
                                <option value="IL">Israel</option>
                                <option value="IT">Italy</option>
                                <option value="JM">Jamaica</option>
                                <option value="JP">Japan</option>
                                <option value="JE">Jersey</option>
                                <option value="JO">Jordan</option>
                                <option value="KZ">Kazakhstan</option>
                                <option value="KE">Kenya</option>
                                <option value="KI">Kiribati</option>
                                <option value="XK">Kosovo</option>
                                <option value="KW">Kuwait</option>
                                <option value="KG">Kyrgyzstan</option>
                                <option value="LA">Laos</option>
                                <option value="LV">Latvia</option>
                                <option value="LB">Lebanon</option>
                                <option value="LS">Lesotho</option>
                                <option value="LR">Liberia</option>
                                <option value="LY">Libya</option>
                                <option value="LI">Liechtenstein</option>
                                <option value="LT">Lithuania</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MO">Macao SAR China</option>
                                <option value="MG">Madagascar</option>
                                <option value="MW">Malawi</option>
                                <option value="MY">Malaysia</option>
                                <option value="MV">Maldives</option>
                                <option value="ML">Mali</option>
                                <option value="MT">Malta</option>
                                <option value="MQ">Martinique</option>
                                <option value="MR">Mauritania</option>
                                <option value="MU">Mauritius</option>
                                <option value="YT">Mayotte</option>
                                <option value="MX">Mexico</option>
                                <option value="MD">Moldova</option>
                                <option value="MC">Monaco</option>
                                <option value="MN">Mongolia</option>
                                <option value="ME">Montenegro</option>
                                <option value="MS">Montserrat</option>
                                <option value="MA">Morocco</option>
                                <option value="MZ">Mozambique</option>
                                <option value="MM">Myanmar (Burma)</option>
                                <option value="NA">Namibia</option>
                                <option value="NR">Nauru</option>
                                <option value="NP">Nepal</option>
                                <option value="NL">Netherlands</option>
                                <option value="NC">New Caledonia</option>
                                <option value="NZ">New Zealand</option>
                                <option value="NI">Nicaragua</option>
                                <option value="NE">Niger</option>
                                <option value="NG">Nigeria</option>
                                <option value="NU">Niue</option>
                                <option value="MK">North Macedonia</option>
                                <option value="NO">Norway</option>
                                <option value="OM">Oman</option>
                                <option value="PK">Pakistan</option>
                                <option value="PS">Palestinian Territories</option>
                                <option value="PA">Panama</option>
                                <option value="PG">Papua New Guinea</option>
                                <option value="PY">Paraguay</option>
                                <option value="PE">Peru</option>
                                <option value="PH">Philippines</option>
                                <option value="PN">Pitcairn Islands</option>
                                <option value="PL">Poland</option>
                                <option value="PT">Portugal</option>
                                <option value="PR">Puerto Rico</option>
                                <option value="QA">Qatar</option>
                                <option value="RE">Réunion</option>
                                <option value="RO">Romania</option>
                                <option value="RU">Russia</option>
                                <option value="RW">Rwanda</option>
                                <option value="WS">Samoa</option>
                                <option value="SM">San Marino</option>
                                <option value="ST">São Tomé &amp; Príncipe</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="SN">Senegal</option>
                                <option value="RS">Serbia</option>
                                <option value="SC">Seychelles</option>
                                <option value="SL">Sierra Leone</option>
                                <option value="SG">Singapore</option>
                                <option value="SX">Sint Maarten</option>
                                <option value="SK">Slovakia</option>
                                <option value="SI">Slovenia</option>
                                <option value="SB">Solomon Islands</option>
                                <option value="SO">Somalia</option>
                                <option value="ZA">South Africa</option>
                                <option value="GS">South Georgia &amp; South Sandwich Islands</option>
                                <option value="KR">South Korea</option>
                                <option value="SS">South Sudan</option>
                                <option value="ES">Spain</option>
                                <option value="LK">Sri Lanka</option>
                                <option value="BL">St. Barthélemy</option>
                                <option value="SH">St. Helena</option>
                                <option value="KN">St. Kitts &amp; Nevis</option>
                                <option value="LC">St. Lucia</option>
                                <option value="MF">St. Martin</option>
                                <option value="PM">St. Pierre &amp; Miquelon</option>
                                <option value="VC">St. Vincent &amp; Grenadines</option>
                                <option value="SR">Suriname</option>
                                <option value="SJ">Svalbard &amp; Jan Mayen</option>
                                <option value="SE">Sweden</option>
                                <option value="CH">Switzerland</option>
                                <option value="TW">Taiwan</option>
                                <option value="TJ">Tajikistan</option>
                                <option value="TZ">Tanzania</option>
                                <option value="TH">Thailand</option>
                                <option value="TL">Timor-Leste</option>
                                <option value="TG">Togo</option>
                                <option value="TK">Tokelau</option>
                                <option value="TO">Tonga</option>
                                <option value="TT">Trinidad &amp; Tobago</option>
                                <option value="TA">Tristan da Cunha</option>
                                <option value="TN">Tunisia</option>
                                <option value="TR">Turkey</option>
                                <option value="TM">Turkmenistan</option>
                                <option value="TC">Turks &amp; Caicos Islands</option>
                                <option value="TV">Tuvalu</option>
                                <option value="UG">Uganda</option>
                                <option value="UA">Ukraine</option>
                                <option value="AE">United Arab Emirates</option>
                                <option value="GB">United Kingdom</option>
                                <option value="US">United States</option>
                                <option value="UY">Uruguay</option>
                                <option value="UZ">Uzbekistan</option>
                                <option value="VU">Vanuatu</option>
                                <option value="VA">Vatican City</option>
                                <option value="VE">Venezuela</option>
                                <option value="VN">Vietnam</option>
                                <option value="WF">Wallis &amp; Futuna</option>
                                <option value="EH">Western Sahara</option>
                                <option value="YE">Yemen</option>
                                <option value="ZM">Zambia</option>
                                <option value="ZW">Zimbabwe</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 input-box">
                        <label class="label-text">What Category?</label>
                        <div class="form-group user-chosen-select-container">
                            <select class="user-chosen-select">
                                <option value="0">Select a Category</option>
                                <option value="1">Shops</option>
                                <option value="2">Hotels</option>
                                <option value="3">Foods & Restaurants</option>
                                <option value="4">Fitness</option>
                                <option value="5">Travel</option>
                                <option value="6">Salons</option>
                                <option value="7">Event</option>
                                <option value="8">Business</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 input-box">
                        <label class="label-text">Filter by Price</label>
                        <div class="form-group user-chosen-select-container">
                            <select class="user-chosen-select">
                                <option value="0">Price Range</option>
                                <option value="1">$ Inexpensive</option>
                                <option value="2">$$ Moderate</option>
                                <option value="3">$$$ Pricey</option>
                                <option value="4">$$$$ Ultra High</option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="section-block"></div>
            </div><!-- end filter-bar-wrap -->
            <div class="row pt-4 padding-left-30px padding-right-30px">
                <div class="col-lg-6 responsive-column-lg">
                    <div class="card-item">
                        <div class="card-image">
                            <a href="listing-details.html" class="d-block">
                                <img src="images/img-loading.png" data-src="images/img4.jpg" class="card__img lazy"
                                     alt="">
                            </a>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">
                                <a href="listing-details.html">Favorite Place Food Bank</a>
                            </h4>
                            <p class="card-sub"><a href="#"><i class="la la-map-marker mr-1 text-color-2"></i>Bishop
                                    Avenue, New York</a></p>
                            <ul class="listing-meta d-flex align-items-center">
                                <li class="d-flex align-items-center">
                                    <span class="rate flex-shrink-0">4.7</span>
                                    <span class="rate-text">5 Ratings</span>
                                </li>
                                <li>
                                <span class="price-range" data-toggle="tooltip" data-placement="top" title="Pricey">
                                    <strong class="font-weight-medium">$</strong>
                                    <strong class="font-weight-medium">$</strong>
                                    <strong class="font-weight-medium">$</strong>
                                </span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="la la-cutlery mr-1 listing-icon"></i><a href="#" class="listing-cat-link">Restaurant</a>
                                </li>
                            </ul>
                            <ul class="info-list padding-top-20px">
                                <li><span class="la la-link icon"></span>
                                    <a href="#"> www.techydevs.com</a>
                                </li>
                                <li><span class="la la-calendar-check-o icon"></span>
                                    Opened 1 month ago
                                </li>
                            </ul>
                        </div>
                    </div><!-- end card-item -->
                </div><!-- end col-lg-6 -->
                <div class="col-lg-6 responsive-column-lg">
                    <div class="card-item">
                        <div class="card-image">
                            <a href="listing-details.html" class="d-block">
                                <img src="images/img-loading.png" data-src="images/img4.jpg" class="card__img lazy"
                                     alt="">
                            </a>
                        </span>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">
                                <a href="listing-details.html">Beach Blue Boardwalk</a>
                            </h4>
                            <p class="card-sub"><a href="#"><i class="la la-map-marker mr-1 text-color-2"></i>Bishop
                                    Avenue, New York</a></p>
                            <ul class="listing-meta d-flex align-items-center">
                                <li class="d-flex align-items-center">
                                    <span class="rate flex-shrink-0">4.7</span>
                                    <span class="rate-text">5 Ratings</span>
                                </li>
                                <li>
                                <span class="price-range" data-toggle="tooltip" data-placement="top" title="Moderate">
                                    <strong class="font-weight-medium">$</strong>
                                    <strong class="font-weight-medium">$</strong>
                                </span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="la la-plane mr-1 listing-icon"></i><a href="#" class="listing-cat-link">Travel</a>
                                </li>
                            </ul>
                            <ul class="info-list padding-top-20px">
                                <li><span class="la la-link icon"></span>
                                    <a href="#"> www.techydevs.com</a>
                                </li>
                                <li><span class="la la-calendar-check-o icon"></span>
                                    Opened 1 month ago
                                </li>
                            </ul>
                        </div>
                    </div><!-- end card-item -->
                </div><!-- end col-lg-6 -->
                <div class="col-lg-6 responsive-column-lg">
                    <div class="card-item">
                        <div class="card-image">
                            <a href="listing-details.html" class="d-block">
                                <img src="images/img-loading.png" data-src="images/img4.jpg" class="card__img lazy"
                                     alt="">
                            </a>
                        </span>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">
                                <a href="listing-details.html">Hotel Govendor</a>
                            </h4>
                            <p class="card-sub"><a href="#"><i class="la la-map-marker mr-1 text-color-2"></i>Bishop
                                    Avenue, New York</a></p>
                            <ul class="listing-meta d-flex align-items-center">
                                <li class="d-flex align-items-center">
                                    <span class="rate flex-shrink-0">4.7</span>
                                    <span class="rate-text">5 Ratings</span>
                                </li>
                                <li>
                                <span class="price-range" data-toggle="tooltip" data-placement="top"
                                      title="Inexpensive">
                                    <strong class="font-weight-medium">$</strong>
                                </span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="la la-hotel mr-1 listing-icon"></i><a href="#" class="listing-cat-link">Hotels</a>
                                </li>
                            </ul>
                            <ul class="info-list padding-top-20px">
                                <li><span class="la la-link icon"></span>
                                    <a href="#"> www.techydevs.com</a>
                                </li>
                                <li><span class="la la-calendar-check-o icon"></span>
                                    Opened 1 month ago
                                </li>
                            </ul>
                        </div>
                    </div><!-- end card-item -->
                </div><!-- end col-lg-6 -->
                <div class="col-lg-6 responsive-column-lg">
                    <div class="card-item">
                        <div class="card-image">
                            <a href="listing-details.html" class="d-block">
                                <img src="images/img-loading.png" data-src="images/img4.jpg" class="card__img lazy"
                                     alt="">
                            </a>
                        </span>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">
                                <a href="listing-details.html">Hotel Govendor</a>
                            </h4>
                            <p class="card-sub"><a href="#"><i class="la la-map-marker mr-1 text-color-2"></i>Bishop
                                    Avenue, New York</a></p>
                            <ul class="listing-meta d-flex align-items-center">
                                <li class="d-flex align-items-center">
                                    <span class="rate flex-shrink-0">4.7</span>
                                    <span class="rate-text">5 Ratings</span>
                                </li>
                                <li>
                                <span class="price-range" data-toggle="tooltip" data-placement="top"
                                      title="Inexpensive">
                                    <strong class="font-weight-medium">$</strong>
                                </span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="la la-hotel mr-1 listing-icon"></i><a href="#" class="listing-cat-link">Hotels</a>
                                </li>
                            </ul>
                            <ul class="info-list padding-top-20px">
                                <li><span class="la la-link icon"></span>
                                    <a href="#"> www.techydevs.com</a>
                                </li>
                                <li><span class="la la-calendar-check-o icon"></span>
                                    Opened 1 month ago
                                </li>
                            </ul>
                        </div>
                    </div><!-- end card-item -->
                </div><!-- end col-lg-6 -->
            </div><!-- end row -->
            <div class="row">
                <div class="col-lg-12 pt-3 text-center pb-5">
                    <div class="pagination-wrapper d-inline-block">
                        <div class="section-pagination">
                            <nav aria-label="Page navigation">
                                <ul class="pagination flex-wrap justify-content-center">
                                    <li class="page-item">
                                        <a class="page-link page-link-first" href="#"><i
                                                class="la la-long-arrow-left mr-1"></i> First</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true"><i class="la la-angle-left"></i></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link page-link-active" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true"><i class="la la-angle-right"></i></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link page-link-last" href="#">Last <i
                                                class="la la-long-arrow-right ml-1"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div><!-- end section-pagination -->
                    </div>
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end card-area -->
        <div class="w-70 home-map">
            <div class="map-container height-980">
                <div id="myMap"></div>
                <a href="#" class="enable-scroll" title="Enable or disable scrolling on map">
                    <i class="la la-mouse mr-2"></i>Enable Scrolling
                </a>
            </div>
        </div><!-- Home Map End -->
    </section>
    <!-- ================================
           END FULL SCREEN AREA
    ================================= -->

    <section class="category-area">
        <div class="card">
            <div class="card-body">
                @forelse($organizations as $organization)
                    <p>{{ $organization->organization_name }} - {{ $organization->state->name }}
                        - {{ $organization->city->name }}
                        - {{ $organization->distance }}</p>
                @empty
                    <p>No gyms found.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const locations = {!! $locations ?? '[]' !!};

            console.log('Locations:', locations); // Log locations data

            if (!Array.isArray(locations)) {
                console.error('Locations is not an array.');
            } else if (locations.length === 0) {
                console.error('Locations array is empty.');
            } else {
                const mapElement = document.getElementById('myMap');
                if (!mapElement) {
                    console.error('Map element not found.');
                } else {
                    const map = L.map('myMap').setView([0, 0], 2); // Initialize map and set the view

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                    }).addTo(map);

                    let firstMarker = null; // To store the first marker with less distance

                    locations.forEach(location => {
                        const marker = L.marker([location.lat, location.lng]);

                        const url = `/${location.city_slug}/gnx/${location.slug}`;

                        // Image path for the popup content
                        const imagePath = '{{ asset("images/business/") }}' + '/' + location.head_photo;

                        let distanceDisplay = '';
                        if (location.distance < 1) {
                            // Display distance in meters if less than 1 km
                            const distanceInMeters = (location.distance * 1000).toFixed(2); // Convert km to meters
                            distanceDisplay = `${distanceInMeters} meters`;
                        } else {
                            // Display distance in kilometers with two decimal places
                            const distanceInKm = location.distance.toFixed(2);
                            distanceDisplay = `${distanceInKm} km`;
                        }

                        // Construct the HTML content for the popup including the clickable image
                        const popupContent = `
                    <a href="${url}" target="_blank">
                        <b>${location.name}</b>
                    </a>
                    <br>
                    <a href="${url}" target="_blank">
                        <img src="${imagePath}" alt="Organization Image" style="max-width: 100px;">
                    </a>
                    <br>
                    <b>${distanceDisplay}</b>
                `;

                        marker.bindPopup(popupContent);

                        // Show popup on mouseover and prevent closing on mouseout
                        marker.on('mouseover', function (e) {
                            this.openPopup();
                        });

                        if (!firstMarker || location.distance < firstMarker.distance) {
                            firstMarker = {
                                distance: location.distance,
                                marker: marker,
                            };
                        }

                        marker.addTo(map);
                    });

                    // Fit the map to display all markers
                    const latlngs = locations.map(location => [location.lat, location.lng]);
                    map.fitBounds(latlngs);

                    // Automatically open popup for the marker with less distance
                    if (firstMarker) {
                        firstMarker.marker.openPopup();
                    }
                }
            }
        });
    </script>
@endsection
