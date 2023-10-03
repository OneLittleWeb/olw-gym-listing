@extends('admin.master_admin')
@section('title', 'Add New Organizations')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
@endsection
@section('content')
    <div class="container-fluid dashboard-inner-body-container">
        <div class="breadcrumb-content d-sm-flex align-items-center justify-content-between mb-4">
            <div class="section-heading">
                <h2 class="sec__title font-size-24 mb-0">Howdy, {{auth()->user()->name ?? "Guest"}}</h2>
            </div>
            <ul class="list-items bread-list bread-list-2">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li>Organizations</li>
            </ul>
        </div><!-- end breadcrumb-content -->
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div
                        class="block-card-header d-flex flex-wrap align-items-center justify-content-between px-4 border-bottom-0 pb-0">
                        <h2 class="widget-title pb-0">Add New Organizations</h2>
                        <a href="{{route('admin.organization.index')}}" class="btn btn-info">View All Organizations<i
                                class="la la-plus-circle ml-1"></i></a>
                    </div>
                    <div class="block-card-body">
                        <form action="{{route('admin.organization.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="block-card mb-4">
                                <div class="block-card-header">
                                    <h2 class="widget-title">General Information</h2>
                                    <div class="stroke-shape"></div>
                                </div><!-- end block-card-header -->
                                <div class="block-card-body">
                                    <div class="form-box row">
                                        <div class="col-lg-12">
                                            <div class="input-box">
                                                <label class="label-text d-flex align-items-center ">Listing Title
                                                    <i class="la la-question tip ml-1" data-toggle="tooltip"
                                                       data-placement="top"
                                                       title="Put your listing title here and tell the name of your business to the world."></i>
                                                </label>
                                                <div class="form-group">
                                                    <span class="la la-briefcase form-icon"></span>
                                                    <input class="form-control" type="text" name="org_title" id="org_title"
                                                           placeholder="Example: Super Duper Burgers">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-12 -->
                                        <div class="col-md-6">
                                            <div class="input-box">
                                                <label class="label-text">Category</label>
                                                <div class="form-group user-chosen-select-container">
                                                    <select class="user-chosen-select" name="category" id="category">
                                                        @foreach($categories as $category)
                                                            <option
                                                                value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div><!-- end form-group -->
                                            </div>
                                        </div><!-- end col-lg-12 -->
                                        <div class="col-lg-12">
                                            <div class="input-box">
                                                <label class="label-text">Description</label>
                                                <div class="form-group">
                                                        <textarea class="message-control form-control user-text-editor"
                                                                  name="org_description" id="org_description"></textarea>
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-12 -->
                                    </div>
                                </div><!-- end block-card-body -->
                            </div><!-- end block-card -->
                            <div class="block-card mb-4">
                                <div class="block-card-header">
                                    <h2 class="widget-title">Location/Contact</h2>
                                    <div class="stroke-shape"></div>
                                </div><!-- end block-card-header -->
                                <div class="block-card-body">
                                    <div class="form-box row">
                                        <div class="col-md-12">
                                            <div class="input-box">
                                                <label class="location">Enter Location: (Autocomplete)</label>
                                                <div class="form-group">
                                                    <span class="la la-map form-icon"></span>
                                                    <input class="form-control" id="searchTextField" type="text"
                                                           placeholder="ex. new york">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Longitude</label>
                                                <div class="form-group">
                                                    <span class="la la-map form-icon"></span>
                                                    <input class="form-control" id="longitude" name="longitude" type="text"
                                                           placeholder="Map Longitude">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Latitude</label>
                                                <div class="form-group">
                                                    <span class="la la-map form-icon"></span>
                                                    <input class="form-control" name="latitude" id="latitude" type="text"
                                                           placeholder="Map Latitude">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-12">
                                            <div class="input-box">
                                                <div class="form-group map-container" id="result">
                                                    <iframe
                                                        width="1200"
                                                        height="450"
                                                        frameborder="0"
                                                        src="https://maps.google.com/maps?q=10.305385,77.923029&hl=es;z=14&output=embed"></iframe>
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-12 -->

                                        <div class="col-md-6">
                                            <div class="input-box">
                                                <label class="label-text">Add Custom Address</label>
                                                <div class="form-group">
                                                    <span class="la la-map-marker form-icon"></span>
                                                    <input class="form-control" type="text" id="address" name="address"
                                                           placeholder="Add address here">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-12 -->
                                        <div class="col-md-6">
                                            <div class="input-box">
                                                <label class="label-text d-flex align-items-center">Web
                                                    Address</label>
                                                <div class="form-group">
                                                    <span class="la la-globe form-icon"></span>
                                                    <input class="form-control" type="text" id="website" name="website"
                                                           placeholder="http://www.companyaddress.com">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-12 -->
                                        <div class="col-lg-12">
                                            <div class="input-box">
                                                <label class="label-text">Iframe</label>
                                                <div class="form-group">
                                                    <textarea class="form-control" id="code" name="iframe"></textarea>
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-4">
                                            <div class="input-box">
                                                <label class="label-text d-flex align-items-center">City
                                                    <i class="la la-question tip ml-1" data-toggle="tooltip"
                                                       data-placement="top"
                                                       title="Provide your city name for your business to show up on the map and your customer can get direction. "></i>
                                                </label>
                                                <div class="form-group">
                                                    <span class="la la-city form-icon"></span>
                                                    <input type="text" name="city" id="city" placeholder="ex. New York"
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-4">
                                            <div class="input-box">
                                                <label class="label-text">Phone</label>
                                                <div class="form-group">
                                                    <span class="la la-phone form-icon"></span>
                                                    <input class="form-control" type="text" id="phone" name="phone"
                                                           placeholder="111-111-1234">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-4">
                                            <div class="input-box">
                                                <label class="label-text">Plus Code</label>
                                                <div class="form-group">
                                                    <span class="la la-phone form-icon"></span>
                                                    <input class="form-control" type="text" id="plus_code"
                                                           name="plus_code"
                                                           placeholder="6VF7+R6 Omaha, NE, USA">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                    </div>
                                </div><!-- end block-card-body -->
                            </div><!-- end block-card -->
                            <div class="block-card mb-4">
                                <div class="block-card-header">
                                    <h2 class="widget-title">Opening Hours</h2>
                                    <div class="stroke-shape"></div>
                                </div><!-- end block-card-header -->
                                <div class="block-card-body">
                                    <div class="form-box table-responsive">
                                        <table class="table time-list mb-0">
                                            <thead>
                                            <tr>
                                                <th class="w-50">Days</th>
                                                <th>Open</th>
                                                <th>Close</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Monday</td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="monday_open"
                                                            id="monday_open">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td><!-- .business-hour-open -->
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="monday_closed"
                                                            id="monday_closed">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td><!-- .business-hour-open -->
                                            </tr><!-- .business-opening-wrap -->
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Tuesday</td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="tuesday_open"
                                                            id="tuesday_open">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="tuesday_closed"
                                                            id="tuesday_closed">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                            </tr><!-- .business-opening-wrap -->
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Wednesday</td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="wednesday_open"
                                                            id="wednesday_open">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="wednesday_closed"
                                                            id="wednesday_closed">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                            </tr><!-- .business-opening-wrap -->
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Thursday</td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="thursday_open"
                                                            id="thursday_open">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="thursday_closed"
                                                            id="thursday_closed">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                            </tr><!-- .business-opening-wrap -->
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Friday</td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="friday_open"
                                                            id="friday_open">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="friday_closed"
                                                            id="friday_closed">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                            </tr><!-- .business-opening-wrap -->
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Saturday</td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="saturday_open"
                                                            id="saturday_open">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="saturday_closed"
                                                            id="saturday_closed">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                            </tr><!-- .business-opening-wrap -->
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Sunday</td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="sunday_open"
                                                            id="sunday_open">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="sunday_closed"
                                                            id="sunday_closed">
                                                        @foreach($selectHours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach

                                                    </select>
                                                </td><!-- .business-hour-open -->
                                            </tr><!-- .business-opening-wrap -->
                                            <tr class="business-opening-wrap">
                                                <td class="business-day w-50">Timezone</td>
                                                <td colspan="2" class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="org_timezone"
                                                            id="org_timezone">
                                                        <option value="">Select a city</option>
                                                        @foreach($timezones as $timezone)
                                                            <option value="{{$timezone}}">{{$timezone}}</option>
                                                        @endforeach
                                                        <optgroup label="Manual Offsets">
                                                            <option value="UTC-12">UTC-12</option>
                                                            <option value="UTC-11.5">UTC-11:30</option>
                                                            <option value="UTC-11">UTC-11</option>
                                                            <option value="UTC-10.5">UTC-10:30</option>
                                                            <option value="UTC-10">UTC-10</option>
                                                            <option value="UTC-9.5">UTC-9:30</option>
                                                            <option value="UTC-9">UTC-9</option>
                                                            <option value="UTC-8.5">UTC-8:30</option>
                                                            <option value="UTC-8">UTC-8</option>
                                                            <option value="UTC-7.5">UTC-7:30</option>
                                                            <option value="UTC-7">UTC-7</option>
                                                            <option value="UTC-6.5">UTC-6:30</option>
                                                            <option value="UTC-6">UTC-6</option>
                                                            <option value="UTC-5.5">UTC-5:30</option>
                                                            <option value="UTC-5">UTC-5</option>
                                                            <option value="UTC-4.5">UTC-4:30</option>
                                                            <option value="UTC-4">UTC-4</option>
                                                            <option value="UTC-3.5">UTC-3:30</option>
                                                            <option value="UTC-3">UTC-3</option>
                                                            <option value="UTC-2.5">UTC-2:30</option>
                                                            <option value="UTC-2">UTC-2</option>
                                                            <option value="UTC-1.5">UTC-1:30</option>
                                                            <option value="UTC-1">UTC-1</option>
                                                            <option value="UTC-0.5">UTC-0:30</option>
                                                            <option value="UTC+0">UTC+0</option>
                                                            <option value="UTC+0.5">UTC+0:30</option>
                                                            <option value="UTC+1">UTC+1</option>
                                                            <option value="UTC+1.5">UTC+1:30</option>
                                                            <option value="UTC+2">UTC+2</option>
                                                            <option value="UTC+2.5">UTC+2:30</option>
                                                            <option value="UTC+3">UTC+3</option>
                                                            <option value="UTC+3.5">UTC+3:30</option>
                                                            <option value="UTC+4">UTC+4</option>
                                                            <option value="UTC+4.5">UTC+4:30</option>
                                                            <option value="UTC+5">UTC+5</option>
                                                            <option value="UTC+5.5">UTC+5:30</option>
                                                            <option value="UTC+5.75">UTC+5:45</option>
                                                            <option value="UTC+6">UTC+6</option>
                                                            <option value="UTC+6.5">UTC+6:30</option>
                                                            <option value="UTC+7">UTC+7</option>
                                                            <option value="UTC+7.5">UTC+7:30</option>
                                                            <option value="UTC+8">UTC+8</option>
                                                            <option value="UTC+8.5">UTC+8:30</option>
                                                            <option value="UTC+8.75">UTC+8:45</option>
                                                            <option value="UTC+9">UTC+9</option>
                                                            <option value="UTC+9.5">UTC+9:30</option>
                                                            <option value="UTC+10">UTC+10</option>
                                                            <option value="UTC+10.5">UTC+10:30</option>
                                                            <option value="UTC+11">UTC+11</option>
                                                            <option value="UTC+11.5">UTC+11:30</option>
                                                            <option value="UTC+12">UTC+12</option>
                                                            <option value="UTC+12.75">UTC+12:45</option>
                                                            <option value="UTC+13">UTC+13</option>
                                                            <option value="UTC+13.75">UTC+13:45</option>
                                                            <option value="UTC+14">UTC+14</option>
                                                        </optgroup>
                                                    </select>
                                                </td><!-- .business-hour-open -->
                                            </tr><!-- .business-opening-wrap -->
                                            </tbody>
                                        </table>
                                    </div><!-- end contact-form-action -->
                                </div><!-- end block-card-body -->
                            </div><!-- end block-card -->
                            <div class="block-card mb-4">
                                <div class="block-card-header">
                                    <h2 class="widget-title">Social Media</h2>
                                    <div class="stroke-shape"></div>
                                </div><!-- end block-card-header -->
                                <div class="block-card-body">
                                    <div class="form-box row">
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Email<span
                                                        class="text-gray font-size-12">(optional)</span></label>
                                                <div class="form-group">
                                                    <span class="la la-mail-bulk form-icon"></span>
                                                    <input class="form-control" type="text" name="email"
                                                           placeholder="example@mail.com">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Facebook Link <span
                                                        class="text-gray font-size-12">(optional)</span></label>
                                                <div class="form-group">
                                                    <span class="la la-facebook-f form-icon"></span>
                                                    <input class="form-control" type="text" name="facebook"
                                                           placeholder="https://">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-12 -->
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Twitter Link <span
                                                        class="text-gray font-size-12">(optional)</span></label>
                                                <div class="form-group">
                                                    <span class="la la-twitter form-icon"></span>
                                                    <input class="form-control" type="text" name="twitter"
                                                           placeholder="https://">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Instagram Link<span
                                                        class="text-gray font-size-12">(optional)</span></label>
                                                <div class="form-group">
                                                    <span class="la la-instagram form-icon"></span>
                                                    <input class="form-control" type="text" name="instagram"
                                                           placeholder="https://">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Skype Link<span
                                                        class="text-gray font-size-12">(optional)</span></label>
                                                <div class="form-group">
                                                    <span class="la la-skype form-icon"></span>
                                                    <input class="form-control" type="text" name="skype"
                                                           placeholder="https://">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Linkedin Link<span
                                                        class="text-gray font-size-12">(optional)</span></label>
                                                <div class="form-group">
                                                    <span class="la la-linkedin form-icon"></span>
                                                    <input class="form-control" type="text" name="linkedin"
                                                           placeholder="https://">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Youtube Link<span
                                                        class="text-gray font-size-12">(optional)</span></label>
                                                <div class="form-group">
                                                    <span class="la la-youtube form-icon"></span>
                                                    <input class="form-control" type="text" name="youtube"
                                                           placeholder="https://">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Trip Advisor Link<span
                                                        class="text-gray font-size-12">(optional)</span></label>
                                                <div class="form-group">
                                                    <span class="la la-tripadvisor form-icon"></span>
                                                    <input class="form-control" type="text" name="tripadvisor"
                                                           placeholder="https://">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->

                                    </div>
                                </div><!-- end block-card-body -->
                            </div><!-- end block-card -->
                            <div class="block-card mb-4">
                                <div class="block-card-header">
                                    <h2 class="widget-title">Media</h2>
                                    <div class="stroke-shape"></div>
                                </div><!-- block-card-header -->
                                <div class="block-card-body">
                                    <label class="label-text">Upload Business Logo</label>
                                    <div class="file-upload-wrap file-upload-wrap-2">
                                        <input type="file" name="files[]"
                                               class="multi file-upload-input with-preview" multiple>
                                        <span class="file-upload-text"><i
                                                class="la la-photo mr-2"></i>Choose a file</span>
                                    </div><!-- file-upload-wrap -->
                                    <label class="label-text">Gallery Images</label>
                                    <div class="file-upload-wrap">
                                        <input type="file" name="files[]"
                                               class="multi file-upload-input with-preview" multiple>
                                        <span class="file-upload-text"><i class="la la-upload mr-2"></i>Drop files here or click to upload</span>
                                    </div><!-- file-upload-wrap -->

                                </div><!-- end block-card-body -->
                            </div><!-- end block-card -->
                            <div class="submit-wrap pt-4">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="agreeChb2">
                                    <label for="agreeChb2" class="text-gray">By continuing, you agree to Listhub's
                                        <a href="terms-and-conditions.html" class="text-color-2">Terms of
                                            Service</a> and
                                        acknowledge our <a href="privacy-policy.html" class="text-color-2">Privacy
                                            Policy</a>.
                                    </label>
                                </div><!-- end custom-checkbox -->
                                <div class="btn-box mt-4">
                                    <button type="submit" class="theme-btn gradient-btn border-0">Save & Preview
                                    </button>
                                </div><!-- end btn-box -->
                            </div><!-- end submit-wrap -->
                        </form>
                    </div><!-- end block-card-body -->
                </div><!-- end block-card -->
            </div><!-- end col-lg-7 -->
        </div><!-- end row -->
    </div><!-- end dashboard-inner-body-container -->
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.5.41/moment-timezone.min.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZruSH0153zHVC2iFBJxWmXnHqAWSn5gw&v=3.exp&sensor=false&libraries=places"></script>
    <script>
        let places, input, address, city, plus_code, phone, website, country;
        var latitude, longitude, html
        google.maps.event.addDomListener(window, "load", function () {
            var places = new google.maps.places.Autocomplete(
                document.getElementById("searchTextField")
            );
            google.maps.event.addListener(places, "place_changed", function () {
                var place = places.getPlace();
                console.log(place);
                latitude = place.geometry.location.lat();
                longitude = place.geometry.location.lng();
                address = place.formatted_address;
                city = place.address_components[0].long_name;
                plus_code = place.plus_code.compound_code;
                // Populate Phone Number
                if (place.formatted_phone_number) {
                    phone = place.formatted_phone_number;
                    $("#phone").val(phone)
                }
                // Populate Website
                if (place.website) {
                    website = place.website;
                    $("#website").val(website)
                }
                // Populate Country, Iframe, Longitude, Latitude, Address, City, Plus Code
                html = `<iframe
                    width="600"
                    height="450"
                    style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    src="https://maps.google.com/maps?q=${latitude},${longitude}&hl=es;z=14&output=embed">
                  </iframe>;`
                $("#result").html(html)
                $("#code").val(html)
                $("#longitude").val(longitude)
                $("#latitude").val(latitude)
                $("#address").val(address)
                $("#city").val(city)
                $("#plus_code").val(plus_code)

                //Select the opening hours and closing time to populate the select boxes
                const openingHours = place.opening_hours.weekday_text;
                const daySelects = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                const openingTimeSuffix = '_open';
                const closingTimeSuffix = '_closed';

                daySelects.forEach(day => {
                    const openingTimeSelect = $(`#${day}${openingTimeSuffix}`).chosen();
                    const closingTimeSelect = $(`#${day}${closingTimeSuffix}`).chosen();

                    openingHours.forEach(hours => {
                        const [dayOfWeek, timeRange] = hours.split(': ');
                        if (dayOfWeek.toLowerCase() === day) {
                            const closedOption = openingTimeSelect.find('option[value="Closed"]');
                            const open24Option = openingTimeSelect.find('option[value="Open 24 Hours"]');

                            if (timeRange === 'Closed') {
                                if (closedOption.length) {
                                    openingTimeSelect.val('Closed').trigger('chosen:updated');
                                }
                                if (open24Option.length) {
                                    openingTimeSelect.val('').trigger('chosen:updated');
                                }
                                closingTimeSelect.val(openingTimeSelect.val()).trigger('chosen:updated');
                            } else if (timeRange === 'Open 24 Hours') {
                                if (closedOption.length) {
                                    openingTimeSelect.val('').trigger('chosen:updated');
                                }
                                if (open24Option.length) {
                                    openingTimeSelect.val('Open 24 Hours').trigger('chosen:updated');
                                }
                                closingTimeSelect.val(openingTimeSelect.val()).trigger('chosen:updated');
                            } else {
                                const [openingTime, closingTime] = timeRange.split('–').map(time => time.trim().replace(/\u00A0/g, ''));
                                const openingTimeOption = openingTimeSelect.find(`option[value="${openingTime.replace(/\s/g, ' ')}"]`);
                                const closingTimeOption = closingTimeSelect.find(`option[value="${closingTime.replace(/\s/g, ' ')}"]`);

                                if (closedOption.length) {
                                    closedOption.prop('selected', false);
                                }
                                if (open24Option.length) {
                                    open24Option.prop('selected', false);
                                }
                                if (openingTimeOption.length) {
                                    openingTimeOption.prop('selected', true);
                                }
                                if (closingTimeOption.length) {
                                    closingTimeOption.prop('selected', true);
                                }

                                openingTimeSelect.trigger('chosen:updated');
                                closingTimeSelect.trigger('chosen:updated');
                            }
                        }
                    });
                });

                //Populate Timezone
                fetch('https://cors-anywhere.herokuapp.com/https://www.timeapi.io/api/TimeZone/coordinate?latitude=25.1972295&longitude=55.27974699999999')
                    .then(response => response.json())
                    .then(data => {
                        // Extract the UTC offset from the response
                        var timezoneName = data.timeZone;
                        var matchTimezone = $("#org_timezone option[value='" + timezoneName + "']");

                        if (matchTimezone.length) {
                            matchTimezone.prop("selected", true).trigger("chosen:updated");
                        }
                    });
            });
        });
    </script>
@endsection
