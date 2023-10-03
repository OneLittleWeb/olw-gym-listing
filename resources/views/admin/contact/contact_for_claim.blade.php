@extends('admin.master_admin')
@section('title', 'Contact for claim')
@section('content')
    <div class="container-fluid dashboard-inner-body-container">
        <div class="breadcrumb-content d-sm-flex align-items-center justify-content-between mb-4">
            <div class="section-heading">
{{--                <h2 class="sec__title font-size-24 mb-0">Howdy, {{auth()->user()->name ?? "Guest"}}</h2>--}}
                <h2 class="sec__title font-size-24 mb-0">Claim Business</h2>
            </div>
            <ul class="list-items bread-list bread-list-2">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li>Claim Business</li>
            </ul>
        </div><!-- end breadcrumb-content -->
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div class="block-card-body">
                        <div class="my-table table-responsive">
                            <table class="table align-items-center table-flush mb-0" id="claim_business_table">
                                <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Business Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Editable Information</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($all_contacts_for_claim as $key => $contact)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{ $contact->organization->organization_name }}</td>
                                        <td>{{$contact->contact_email}}</td>
                                        <td>{{$contact->contact_number}}</td>
                                        <td>{{$contact->editable_information}}</td>
                                        <td style="width: 15%">
                                            @if(!$contact->organization->claimed_mail && !$contact->organization->is_claimed)
                                                <form class="d-inline" method="post"
                                                      action="{{ route('admin.claim.status.update', ['id' => $contact->id, 'status' => 'approved']) }}">
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-primary claim-approve"
                                                            data-toggle="tooltip" data-placement="top" title="Approve">
                                                        <i
                                                            class="fa fa-check" aria-hidden="true"></i></button>
                                                </form>

                                                <form method="post"
                                                      action="{{ route('admin.claim.status.update', ['id' => $contact->id, 'status' => 'cancel']) }}"
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger claim-cancel"
                                                            data-toggle="tooltip" data-placement="top" title="Cancel"><i
                                                            class="fa fa-times" aria-hidden="true"></i></button>
                                                </form>
                                            @elseif($contact->organization->claimed_mail && !$contact->organization->is_claimed)
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        data-toggle="tooltip" data-placement="top" title="Canceled">
                                                    Cancelled
                                                </button>
                                            @elseif($contact->organization->claimed_mail && $contact->organization->is_claimed)
                                                <button type="button" class="btn btn-sm btn-success"
                                                        data-toggle="tooltip" data-placement="top" title="Approved">
                                                    Approved
                                                </button>
                                            @endif

                                            <div class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-info d-inline"
                                                        data-toggle="tooltip" data-placement="top" title="Details">
                                                    <i
                                                        class="fa fa-eye" aria-hidden="true"></i></button>
                                            </div>
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
                          action="#" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-form-label">
                                            <label for="first-name">Name <sub class="text-danger">*</sub></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="hidden" class="form-control" id="category_id"
                                                   name="category_id">
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
    <script>
        $(document).on('click', 'button.claim-approve', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to approve this business claim?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent('form').trigger('submit')
                }
            });
        });

        $(document).on('click', 'button.claim-cancel', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to cancel this business claim?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent('form').trigger('submit')
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#claim_business_table').DataTable();

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
                modal.find('.modal-body #old_bg_image').attr("src", window.location.origin + '/' + background_image);
                modal.find('.modal-body #category_id').val(category_id);
                modal.find('.modal-body #meta_keywords').val(metakeywords);
                modal.find('.modal-body #meta_description').html(metadescrition);
            });
        });
    </script>
@endsection
