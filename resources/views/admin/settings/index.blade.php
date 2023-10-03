@extends('admin.master_admin')
@section('title', 'Settings')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
@endsection
@section('content')
   <div class="container-fluid dashboard-inner-body-container">
                <div class="breadcrumb-content d-sm-flex align-items-center justify-content-between mb-4">
                    <div class="section-heading">
                        <h2 class="sec__title font-size-24 mb-0">Site Settings</h2>
                    </div>
                    <ul class="list-items bread-list bread-list-2">
                        <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li>Site Settings</li>
                    </ul>
                </div><!-- end breadcrumb-content -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="block-card dashboard-card mb-4">
                            <div class="block-card-header">
                                <h2 class="widget-title pb-0">General Settings</h2>
                            </div>
                            <div class="block-card-body">
                                <div class="edit-profile-photo d-flex align-items-center">
                                    <img src="images/team1.jpg" alt="" class="profile-img">
                                    <div class="file-upload-wrap file-upload-wrap-2 ml-4">
                                        <div class="MultiFile-wrap" id="MultiFile1"><input type="file" name="files[]" class="multi file-upload-input with-preview MultiFile-applied" multiple="" maxlength="1" id="MultiFile1" value=""><div class="MultiFile-list" id="MultiFile1_list"></div></div>
                                        <span class="file-upload-text"><i class="la la-photo mr-2"></i>Upload Photo</span>
                                        <p>Maximum file size: 10 MB.</p>
                                    </div>
                                </div><!-- end edit-profile-photo -->
                                <form method="post" class="form-box row pt-4 MultiFile-intercepted">
                                    <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text">Site Title</label>
                                            <div class="form-group">
                                                <span class="la la-user form-icon"></span>
                                                <input class="form-control" type="text" name="site_title" id="site_title" value="Kamran Ahmed">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                    <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text">Site Description</label>
                                            <div class="form-group">
                                                <span class="la la-envelope-o form-icon"></span>
                                                <input class="form-control" type="email" name="email" value="kamran123@gmail.com">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-12 -->

                                    <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text">Footer Credit</label>
                                            <div class="form-group">
                                                <span class="la la-globe form-icon"></span>
                                                <textarea class="form-control" name="footer_credit" id="footer_credit" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                    <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text">Notes</label>
                                            <div class="form-group">
                                                <span class="la la-pencil form-icon"></span>
                                                <textarea class="message-control form-control" name="message">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum, quos?</textarea>
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-12 -->

                                    <div class="col-lg-12">
                                        <div class="btn-box pt-1">
                                            <button class="theme-btn gradient-btn border-0">Save Changes<i class="la la-arrow-right ml-2"></i></button>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                </form>
                            </div><!-- end block-card-body -->
                        </div><!-- end block-card -->
                    </div><!-- end col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="block-card dashboard-card mb-4">
                            <div class="block-card-header">
                                <h2 class="widget-title pb-0">Contact Settings</h2>
                            </div>
                            <div class="block-card-body">
                                <form method="post" class="form-box row MultiFile-intercepted" data-bitwarden-watching="1">
                                     <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text">Phone Number</label>
                                            <div class="form-group">
                                                <span class="la la-phone form-icon"></span>
                                                <input class="form-control" type="text" name="text" value="+7(123)987654">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                     <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text">Email</label>
                                            <div class="form-group">
                                                <span class="la la-mail form-icon"></span>
                                                <input class="form-control" type="email" name="email" value="+7(123)987654">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                    <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text">Address</label>
                                            <div class="form-group">
                                                <span class="la la-map-marker form-icon"></span>
                                                <input class="form-control" type="text" name="text" value="USA 27TH Brooklyn NY">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                    <div class="col-lg-12">
                                        <div class="btn-box pt-1">
                                            <button class="theme-btn gradient-btn border-0">Change Password<i class="la la-arrow-right ml-2"></i></button>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                </form>
                            </div><!-- end block-card-body -->
                        </div><!-- end block-card -->
                        <div class="block-card dashboard-card mb-4">
                            <div class="block-card-header">
                                <h2 class="widget-title pb-0">Social Setting</h2>
                            </div>
                            <div class="block-card-body">
                                <form method="post" class="form-box row MultiFile-intercepted">
                                     <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text">Facebook</label>
                                            <div class="form-group">
                                                <span class="la la-facebook form-icon"></span>
                                                <input class="form-control" type="text" name="name" placeholder="www.facebook.com">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                    <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text">Twitter</label>
                                            <div class="form-group">
                                                <span class="la la-twitter form-icon"></span>
                                                <input class="form-control" type="text" name="text" placeholder="www.twitter.com">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                    <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text">Instagram</label>
                                            <div class="form-group">
                                                <span class="la la-instagram form-icon"></span>
                                                <input class="form-control" type="text" name="text" placeholder="www.instagram.com">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                    <div class="col-lg-12">
                                        <div class="btn-box pt-1">
                                            <button class="theme-btn gradient-btn border-0">Change Email<i class="la la-arrow-right ml-2"></i></button>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                </form>
                            </div><!-- end block-card-body -->
                        </div><!-- end block-card -->
                    </div><!-- end col-lg-6 -->
                </div><!-- end row -->
            </div>
@endsection
@section('js')
@endsection
