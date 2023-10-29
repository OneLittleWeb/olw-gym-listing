@extends('admin.master_admin')
@section('title', 'Cities')
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
                <li>Cities</li>
            </ul>
        </div><!-- end breadcrumb-content -->
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div
                        class="block-card-header d-flex flex-wrap align-items-center justify-content-between px-4 border-bottom-0 pb-0">
                        <h2 class="widget-title pb-0">All Cities</h2>
                        <button data-toggle="modal" data-target="#addCity" class="btn btn-info">Add New City<i
                                class="la la-plus-circle ml-1"></i></button>
                    </div>
                    <div class="block-card-body">
                        <div class="my-table table-responsive">
                            <table class="table align-items-center table-flush mb-0" id="city_table">
                                <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Is Major</th>
                                    <th>Population</th>
                                    <th>Background Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cities as $key => $city)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{Str::title($city->name)}}</td>
                                        <td>{{$city->slug}}</td>
                                        <td><input type="checkbox" {{$city->is_major == 1 ? 'checked' : ''}}></td>
                                        <td>{{$city->population}}</td>
                                        <td><img src="{{asset($city->background_image)}}" alt="{{$city->name}}"
                                                 width="30"></td>
                                        <td>
                                            <form action="{{route('admin.city.destroy',$city->id)}}"
                                                  onsubmit="return confirm('Do you really want to delete?');"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        class="btn btn-sm btn-primary"
                                                        data-toggle="modal"
                                                        data-target="#editCity"
                                                        data-city="{{$city->name}}"
                                                        data-slug="{{$city->slug}}"
                                                        data-is_major="{{$city->is_major}}"
                                                        data-population="{{$city->population}}"
                                                        data-background_image="{{$city->background_image}}"
                                                        @if(!is_null($city->meta))
                                                            data-metakeywords="{{json_decode($city->meta)->meta_keywords}}"
                                                        data-metadescrition="{{json_decode($city->meta)->meta_description}}"
                                                        @endif
                                                        data-city_id="{{$city->id}}">Edit
                                                </button>
                                                <button type="submit" class="btn btn-sm btn-danger">Delete
                                                </button>

                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end block-card-body -->
                </div><!-- end block-card -->
            </div><!-- end col-lg-7 -->
        </div><!-- end row -->

        <!-- Add City Modal -->
        <div class="modal fade" id="addCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New City</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form form-horizontal" method="POST" action="{{route('admin.city.store')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Name <sub class="text-danger">*</sub></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="name" class="form-control" name="name"
                                                   placeholder="Example: New York" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Slug <sub class="text-danger">*</sub></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="slug" class="form-control" name="slug"
                                                   placeholder="Example: new-york" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Is Major <sub class="text-danger">*</sub></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="checkbox" id="is_major" class="form-control" name="is_major"
                                                   value="1">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Population</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" id="population" class="form-control" name="population"
                                                   placeholder="Example: bg-1">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Background Image</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="file" id="background_image" class="form-control"
                                                   name="background_image" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="border rounded p-2">
                                        <h6 class="mb-1">SEO & Social Settings</h6>
                                        <div class="form-group mb-2">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control"
                                                       id="meta_keywords"
                                                       name="meta_keywords">
                                                @error('meta_keywords')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="meta_description">Meta Description</label>
                                            <div class="position-relative">
                                                <textarea class="form-control" id="meta_description"
                                                          name="meta_description"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light">
                                Submit
                            </button>
                            <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- end Add City Modal -->

        <!-- Edit City Modal -->
        <div class="modal fade" id="editCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit City</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form form-horizontal" method="POST"
                          action="{{route('admin.city.update','city_id')}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Name <sub class="text-danger">*</sub></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="hidden" class="form-control" id="city_id" name="city_id">
                                            <input type="text" id="name" class="form-control" name="name"
                                                   placeholder="Example: Science" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Slug <sub class="text-danger">*</sub></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="slug" class="form-control" name="slug"
                                                   placeholder="Example: new-york" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Is Major</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="checkbox" id="is_major" class="form-control" name="is_major"
                                                   value="1"
                                                   placeholder="Example: fa fa-desktop" required >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Population</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" id="population" class="form-control" name="population"
                                                   placeholder="Example: bg-1">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Background Image</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="file" id="background_image" class="form-control"
                                                   name="background_image" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Old BG Image</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <img src="" alt="" width="100" id="old_bg_image">
                                            <input type="hidden" name="old_image" id="old_image" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="border rounded p-2">
                                        <h6 class="mb-1">SEO & Social Settings</h6>
                                        <div class="form-group mb-2">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control"
                                                       id="meta_keywords"
                                                       name="meta_keywords">
                                                @error('meta_keywords')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="meta_description">Meta Description</label>
                                            <div class="position-relative">
                                                                    <textarea class="form-control" id="meta_description"
                                                                              name="meta_description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light">
                                Update
                            </button>
                            <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- end Edit City Modal -->
    </div><!-- end dashboard-inner-body-container -->
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#city_table').DataTable();

            $('#editCity').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var city = button.data('city')
                var slug = button.data('slug')
                var is_major = button.data('is_major')
                var population = button.data('population')
                var background_image = button.data('background_image')
                var metakeywords = button.data('metakeywords')
                var metadescrition = button.data('metadescrition')
                var city_id = button.data('city_id')
                var modal = $(this)
                modal.find('.modal-tile').text('Edit City');
                modal.find('.modal-body #name').val(city);
                modal.find('.modal-body #slug').val(slug);
                modal.find('.modal-body #is_major').prop('checked', is_major == 1);
                modal.find('.modal-body #population').val(population);
                modal.find('.modal-body #old_image').val(background_image);
                modal.find('.modal-body #old_bg_image').attr("src", window.location.origin + '/' + background_image);
                modal.find('.modal-body #city_id').val(city_id);
                modal.find('.modal-body #meta_keywords').val(metakeywords);
                modal.find('.modal-body #meta_description').html(metadescrition);
            });

            $('#name').on('keyup', function () {
                var name = $(this).val();
                var slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
                $('#slug').val(slug);
            });
        });
    </script>
@endsection
