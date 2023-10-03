@extends('admin.master_admin')
@section('title', 'Edit Plan')
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
                <li>Edit Plan</li>
            </ul>
        </div><!-- end breadcrumb-content -->
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div
                        class="block-card-header d-flex flex-wrap align-items-center justify-content-between px-4 border-bottom-0 pb-0">
                        <h2 class="widget-title pb-0">Edit {{$plan->name}}</h2>
                        <a href="{{route('admin.plan.index')}}" class="btn btn-info">View All Plans<i
                                class="la la-plus-circle ml-1"></i></a>
                    </div>
                    <div class="block-card-body">
                        <form action="{{route('admin.plan.update',$plan->id)}}" method="POST">
                            @csrf
                            @method('PUT')
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
                                                           placeholder="Example: Professional Plan"
                                                           value="{{$plan->name}}">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->

                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Slug</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="slug" id="slug"
                                                           placeholder="Example: professional-plan"
                                                           value="{{$plan->slug}}">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->

                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Price</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="price" id="price"
                                                           placeholder="Example: 199" value="{{$plan->price}}">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->

                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Timeframe</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="abbreviation"
                                                           id="abbreviation"
                                                           placeholder="Example: 3 months"
                                                           value="{{$plan->abbreviation}}">
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
                                                           placeholder="Example: price_1Mt9luDagRG4n09BEQgtwByo"
                                                           value="{{$plan->stripe_id}}">
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-6 -->

                                        <div class="col-lg-6">
                                            <div class="input-box">
                                                <label class="label-text">Stripe Name</label>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="stripe_name"
                                                           id="stripe_name"
                                                           placeholder="Example: Professional"
                                                           value="{{$plan->stripe_name}}">
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
                                                    @if(!is_null($plan->included))
                                                        @foreach(json_decode($plan->included) as $key => $includes )
                                                            <div class="dynamic-include">
                                                                <div class="col-12">
                                                                    <div class="form-group mb-2">
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                   id="dynamicIncludeFields[{{$key}}]"
                                                                                   name="dynamicIncludeFields[{{$key}}]"
                                                                                   class="form-control"
                                                                                   value="{{$includes}}"
                                                                            >
                                                                            <div class="input-group-append">
                                                                                <button
                                                                                    class="btn btn-danger remove-input-field"
                                                                                    id="basic-addon2">Remove
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif

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
                                                    @if(!is_null($plan->not_included))
                                                        @foreach(json_decode($plan->not_included) as $key => $notincludes )
                                                            <div class="dynamic-not-include">
                                                                <div class="col-12">
                                                                    <div class="form-group mb-2">
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                   id="dynamicNotIncludeFields[{{$key}}]"
                                                                                   name="dynamicNotIncludeFields[{{$key}}]"
                                                                                   class="form-control"
                                                                                   value="{{$notincludes}}"
                                                                            >
                                                                            <div class="input-group-append">
                                                                                <button
                                                                                    class="btn btn-danger remove-input-field"
                                                                                    id="basic-addon2">Remove
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
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
        var i = {{is_null($plan->included) ? '0' : array_key_last(json_decode($plan->included,true))}};
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
        var j = {{is_null($plan->not_included) ? '0' : array_key_last(json_decode($plan->not_included,true))}};
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
