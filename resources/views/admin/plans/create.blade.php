@extends('admin.master_admin')
@section('title', 'Add New Plans')
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
                <li>Plans</li>
            </ul>
        </div><!-- end breadcrumb-content -->
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div
                        class="block-card-header d-flex flex-wrap align-items-center justify-content-between px-4 border-bottom-0 pb-0">
                        <h2 class="widget-title pb-0">Add New Plan</h2>
                        <a href="{{route('admin.plan.index')}}" class="btn btn-info">View All Plans<i
                                class="la la-plus-circle ml-1"></i></a>
                    </div>
                    <div class="block-card-body">
                        <form action="{{route('admin.plan.store')}}" method="POST">
                            @csrf
                            <div class="block-card mb-4">
                                <div class="block-card-header">
                                    <h2 class="widget-title">General Information</h2>
                                    <div class="stroke-shape"></div>
                                </div><!-- end block-card-header -->
                                <div class="block-card-body">
                                    <div class="form-box row">
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text d-flex align-items-center ">Name</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="name" id="name"
                                                           placeholder="Example: Professional Plan" value="{{old('name')}}">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->

                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Slug</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="slug" id="slug"
                                                           placeholder="Example: professional-plan" value="{{old('slug')}}">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->

                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Price</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="price" id="price"
                                                           placeholder="Example: 199" value="{{old('price')}}">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->

                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Timeframe</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="abbreviation"
                                                           id="abbreviation"
                                                           placeholder="Example: 3 months" value="{{old('abbreviation')}}">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                    </div>
                                </div><!-- end block-card-body -->
                            </div><!-- end block-card -->
                            <div class="block-card mb-4">
                                <div class="block-card-header">
                                    <h2 class="widget-title">Stripe Product info</h2>
                                    <div class="stroke-shape"></div>
                                </div><!-- end block-card-header -->
                                <div class="block-card-body">
                                    <div class="form-box row">
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Stripe Price ID</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="stripe_id"
                                                           id="stripe_id"
                                                           placeholder="Example: price_1Mt9luDagRG4n09BEQgtwByo" value="{{old('stripe_id')}}">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->

                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Stripe Name</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="stripe_name"
                                                           id="stripe_name"
                                                           placeholder="Example: Professional" value="{{old('stripe_name')}}">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                    </div>
                                </div><!-- end block-card-body -->
                            </div><!-- end block-card -->
                            <div class="block-card mb-4">
                                <div class="block-card-header">
                                    <h2 class="widget-title">Include/ Not Include</h2>
                                    <div class="stroke-shape"></div>
                                </div><!-- end block-card-header -->
                                <div class="block-card-body">
                                    <div class="form-box row">
                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <style>
                                                    .dynamic-include, .dynamic-not-include {
                                                        width: 100%;
                                                    }
                                                </style>
                                                <label class="label-text">The plan includes</label>
                                                <div class="row" id="addIncludes">

                                                </div>
                                                <button id="addIncludeRow" type="button" class="btn btn-info">
                                                    Add New Include
                                                </button>
                                            </div>
                                        </div><!-- end col-lg-6 -->

                                         <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">The plan doesn't include</label>
                                                <div class="row" id="addNotIncludes">

                                                </div>
                                                <button id="addNotIncludeRow" type="button" class="btn btn-info">
                                                    Add New Not Include
                                                </button>
                                            </div>
                                        </div><!-- end col-lg-6 -->
                                    </div>
                                </div><!-- end block-card-body -->
                            </div><!-- end block-card -->
                            <div class="submit-wrap">
                                <div class="btn-box mt-4 ml-4">
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
    <script>
        function slugify(str) {
            return str.toLowerCase().trim().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, '');
        }

        $(document).ready(function () {
            var name = $('#name');
            var slug = $('#slug');

            name.on('keyup', function () {
                slug.val(slugify(name.val()));
            });
        });

        //Add Include Rows
        var i = 0;
        $("#addIncludeRow").click(function () {
            ++i;
            var html = '';
            html += '<div class="dynamic-include">';
            html += '<div class="col-12">';
            html += '<div class="form-group mb-2">';
            html += '<div class="input-group">';
            html += '<input type="text" id="dynamicIncludeFields[' + i + ']" name="dynamicIncludeFields[' + i + ']" class="form-control">';
            html += '<div class="input-group-append"><button class="btn btn-danger remove-input-field" id="basic-addon2">Remove</button></div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            $('#addIncludes').append(html);
        });

        // remove Include row
        $(document).on('click', '.remove-input-field', function (e) {
            e.preventDefault();
            $(this).parents('.dynamic-include').remove();
        });

        //Add Not Include Rows
        var j = 0;
        $("#addNotIncludeRow").click(function () {
            ++j;
            var html = '';
            html += '<div class="dynamic-not-include">';
            html += '<div class="col-12">';
            html += '<div class="form-group mb-2">';
            html += '<div class="input-group">';
            html += '<input type="text" id="dynamicNotIncludeFields[' + j + ']" name="dynamicNotIncludeFields[' + j + ']" class="form-control">';
            html += '<div class="input-group-append"><button class="btn btn-danger remove-input-field" id="basic-addon2">Remove</button></div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            $('#addNotIncludes').append(html);
        });

        // remove Include row
        $(document).on('click', '.remove-input-field', function (e) {
            e.preventDefault();
            $(this).parents('.dynamic-not-include').remove();
        });
    </script>
@endsection
