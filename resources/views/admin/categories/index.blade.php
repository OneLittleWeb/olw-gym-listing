@extends('admin.master_admin')
@section('title', 'Categories')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
@endsection
@section('content')
    <div class="container-fluid dashboard-inner-body-container">
        <div class="breadcrumb-content d-sm-flex align-items-center justify-content-between mb-4">
            <div class="section-heading">
                <h2 class="sec__title font-size-24 mb-0">Howdy, Your Name</h2>
            </div>
            <ul class="list-items bread-list bread-list-2">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li>Categories</li>
            </ul>
        </div><!-- end breadcrumb-content -->
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div
                        class="block-card-header d-flex flex-wrap align-items-center justify-content-between px-4 border-bottom-0 pb-0">
                        <h2 class="widget-title pb-0">All Categories</h2>
                        <button data-toggle="modal" data-target="#addCategory" class="btn btn-info">Add New Category<i
                                class="la la-plus-circle ml-1"></i></button>
                    </div>
                    <div class="block-card-body">
                        <div class="my-table table-responsive">
                            <table class="table align-items-center table-flush mb-0" id="category_table">
                                <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Icon</th>
                                    <th>Background</th>
                                    <th>Background Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $key => $category)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{\Illuminate\Support\Str::title($category->name)}}</td>
                                        <td>{{$category->slug}}</td>
                                        <td>{{$category->icon}}</td>
                                        <td>{{$category->background}}</td>
                                        <td><img src="{{asset($category->background_image)}}" alt="{{$category->name}}"
                                                 width="30"></td>
                                        <td>
                                            <form action="{{route('admin.category.destroy',$category->id)}}"
                                                  onsubmit="return confirm('Do you really want to delete?');"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                   class="btn btn-sm btn-primary"
                                                   data-toggle="modal"
                                                   data-target="#editCategory"
                                                   data-category="{{$category->name}}"
                                                   data-icon="{{$category->icon}}"
                                                   data-background="{{$category->background}}"
                                                   data-background_image="{{$category->background_image}}"
                                                   @if(!is_null($category->meta))
                                                   data-metakeywords="{{json_decode($category->meta)->meta_keywords}}"
                                                   data-metadescrition="{{json_decode($category->meta)->meta_description}}"
                                                   @endif
                                                   data-category_id="{{$category->id}}">Edit</button>
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

        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form form-horizontal" method="POST" action="{{route('admin.category.store')}}"
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
                                                   placeholder="Example: Science" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Icon <sub class="text-danger">*</sub></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="icon" class="form-control" name="icon"
                                                   placeholder="Example: fa fa-desktop" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Background</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="background" class="form-control" name="background"
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
        </div><!-- end Add Category Modal -->

        <!-- Edit Category Modal -->
        <div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form form-horizontal" method="POST"
                          action="{{route('admin.category.update','category_id')}}" enctype="multipart/form-data" >
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
                                            <input type="hidden" class="form-control" id="category_id" name="category_id">
                                            <input type="text" id="name" class="form-control" name="name"
                                                   placeholder="Example: Science" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Icon <sub class="text-danger">*</sub></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="icon" class="form-control" name="icon"
                                                   placeholder="Example: fa fa-desktop" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Background</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="background" class="form-control" name="background"
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
        </div><!-- end Edit Category Modal -->
    </div><!-- end dashboard-inner-body-container -->
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#category_table').DataTable();

            $('#editCategory').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var category = button.data('category')
                var icon = button.data('icon')
                var background = button.data('background')
                var background_image = button.data('background_image')
                var metakeywords = button.data('metakeywords')
                var metadescrition = button.data('metadescrition')
                var category_id = button.data('category_id')
                var modal = $(this)
                modal.find('.modal-tile').text('Edit Category');
                modal.find('.modal-body #name').val(category);
                modal.find('.modal-body #icon').val(icon);
                modal.find('.modal-body #background').val(background);
                modal.find('.modal-body #old_image').val(background_image);
                modal.find('.modal-body #old_bg_image').attr("src", window.location.origin+'/'+background_image);
                modal.find('.modal-body #category_id').val(category_id);
                modal.find('.modal-body #meta_keywords').val(metakeywords);
                modal.find('.modal-body #meta_description').html(metadescrition);
            });
        });
    </script>
@endsection
