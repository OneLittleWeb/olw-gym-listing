<!DOCTYPE html>
<html class="loading semi-dark-layout" lang="en" data-layout="semi-dark-layout" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{asset('/images/favicon.png')}}">
    <title>Login - {{request()->getHost()}}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('BackEnd')}}/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/all.min.css"
          integrity="sha512-QfDd74mlg8afgSqm3Vq2Q65e9b3xMhJB4GZ9OcHDVy1hZ6pqBJPWWnMsKDXM7NINoKqJANNGBuVRIpIJ5dogfA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body>
<!-- BEGIN: Content-->
<style>
    .form-bg {
        background: #00b4ef;
        height: 100vh;
    }

    .form-horizontal {
        background: #fff;
        padding-bottom: 100px;
        border-radius: 15px;
        text-align: center;
    }

    .form-horizontal .heading {
        display: block;
        font-size: 35px;
        font-weight: 700;
        padding: 35px 0;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 30px;
    }

    .form-horizontal .form-group {
        padding: 0 40px;
        margin: 0 0 25px 0;
        position: relative;
    }

    .form-horizontal .form-control {
        background: #f0f0f0;
        border: none;
        border-radius: 20px;
        box-shadow: none;
        padding: 0 20px 0 45px;
        height: 40px;
        transition: all 0.3s ease 0s;
    }

    .form-horizontal .form-control:focus {
        background: #e0e0e0;
        box-shadow: none;
        outline: 0 none;
    }

    .form-horizontal .form-group i {
        position: absolute;
        top: 12px;
        left: 60px;
        font-size: 17px;
        color: #c8c8c8;
        transition: all 0.5s ease 0s;
    }

    .form-horizontal .form-control:focus + i {
        color: #00b4ef;
    }

    .form-horizontal .fa-question-circle {
        display: inline-block;
        position: absolute;
        top: 12px;
        right: 60px;
        font-size: 20px;
        color: #808080;
        transition: all 0.5s ease 0s;
    }

    .form-horizontal .fa-question-circle:hover {
        color: #000;
    }

    .form-horizontal .main-checkbox {
        float: left;
        width: 20px;
        height: 20px;
        background: #11a3fc;
        border-radius: 50%;
        position: relative;
        margin: 5px 0 0 5px;
        border: 1px solid #11a3fc;
    }

    .form-horizontal .main-checkbox label {
        width: 20px;
        height: 20px;
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
    }

    .form-horizontal .main-checkbox label:after {
        content: "";
        width: 10px;
        height: 5px;
        position: absolute;
        top: 5px;
        left: 4px;
        border: 3px solid #fff;
        border-top: none;
        border-right: none;
        background: transparent;
        opacity: 0;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
    }

    .form-horizontal .main-checkbox input[type=checkbox] {
        visibility: hidden;
    }

    .form-horizontal .main-checkbox input[type=checkbox]:checked + label:after {
        opacity: 1;
    }

    .form-horizontal .text {
        float: left;
        margin-left: 7px;
        line-height: 20px;
        padding-top: 5px;
        text-transform: capitalize;
    }

    .form-horizontal .btn {
        float: right;
        font-size: 14px;
        color: #fff;
        background: #00b4ef;
        border-radius: 30px;
        padding: 10px 25px;
        border: none;
        text-transform: capitalize;
        transition: all 0.5s ease 0s;
    }

    @media only screen and (max-width: 479px) {
        .form-horizontal .form-group {
            padding: 0 25px;
        }

        .form-horizontal .form-group i {
            left: 45px;
        }

        .form-horizontal .btn {
            padding: 10px 20px;
        }
    }
</style>
<div class="form-bg">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-md-offset-3 col-md-6">
                <form class="form-horizontal" action="{{route('login')}}" method="POST">
                    @csrf
                    <span class="heading">Log In</span>
                    <div class="form-group">
                        <input type="email" class="form-control" id="inputEmail3" name="email"
                               placeholder="Email or Username">
                        <i class="fa fa-user"></i>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group help">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="Password"
                               name="password">
                        <i class="fa fa-lock"></i>
                        <a href="#" class="fa fa-question-circle"></a>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                        @enderror
                    </div>

                    @if(!$errors->isEmpty())
                        <div class="alert alert-red text-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <div class="main-checkbox">
                            <input type="checkbox" value="None" id="checkbox1" name="check">
                            <label for="checkbox1"></label>
                        </div>
                        <span class="text">Remember me</span>
                        <button type="submit" class="btn btn-default">log in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

<!-- BEGIN: Vendor JS-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>
<!-- END: Body-->
</html>
