@extends('admin.master_admin')
@section('title', 'Suggest an edit Request')
@section('content')
    <div class="container-fluid dashboard-inner-body-container">
        <div class="breadcrumb-content d-sm-flex align-items-center justify-content-between mb-4">
            <div class="section-heading">
{{--                <h2 class="sec__title font-size-24 mb-0">Howdy, {{auth()->user()->name ?? "Guest"}}</h2>--}}
                <h2 class="sec__title font-size-24 mb-0">Suggest An Edit Request</h2>
            </div>
            <ul class="list-items bread-list bread-list-2">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li>Suggest Edit</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div class="block-card-body">
                        <div class="my-table table-responsive">
                            <table class="table align-items-center table-flush mb-0" id="suggest_edit_request_table">
                                <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Business Name</th>
                                    <th>Is It Closed</th>
                                    <th>Temporarily Closed</th>
                                    <th>Owner</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($suggest_edit_requests as $key => $edit_request)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td><a href="{{ route('city.wise.organization', ['city_slug' => $edit_request->organization->city->slug, 'organization_slug' => $edit_request->organization->slug]) }}" target="_blank">{{ $edit_request->organization->organization_name }}</a></td>
                                        <td>
                                            @if($edit_request->is_it_closed)
                                                <span class="text-danger">Yes</span>
                                            @else
                                                <span class="text-success">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($edit_request->temporarily_closed)
                                                <span class="text-danger">Yes</span>
                                            @else
                                                <span class="text-success">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($edit_request->are_you_the_owner)
                                                <span class="text-success">Yes</span>
                                            @else
                                                <span class="text-danger">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($edit_request->edit_status == 0)
                                                <span
                                                    class="badge badge-warning">Pending</span>
                                            @elseif($edit_request->edit_status == 1)
                                                <span
                                                    class="badge badge-success">Approved</span>
                                            @else
                                                <span
                                                    class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="width: 15%">

                                            @if($edit_request->edit_status == 0 )
                                                <form class="d-inline" method="post"
                                                      action="{{ route('admin.edit.request.update', ['id' => $edit_request->id, 'status' => 'approved']) }}">
                                                    @csrf
                                                    <button type="button"
                                                            class="btn btn-sm btn-primary approve-suggest-request"
                                                            data-toggle="tooltip" data-placement="top" title="Approve">
                                                        <i class="fa fa-check" aria-hidden="true"></i></button>
                                                </form>

                                                <form method="post"
                                                      action="{{ route('admin.edit.request.update', ['id' => $edit_request->id, 'status' => 'rejected']) }}"
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="button"
                                                            class="btn btn-sm btn-danger reject-suggested-request"
                                                            data-toggle="tooltip" data-placement="top" title="Reject"><i
                                                            class="fa fa-times" aria-hidden="true"></i></button>
                                                </form>
                                            @else
                                                <form method="post"
                                                      action="{{ route('admin.edit.request.update', ['id' => $edit_request->id, 'status' => 'deleted']) }}"
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="button"
                                                            class="btn btn-sm btn-danger delete-suggested-request"
                                                            data-toggle="tooltip" data-placement="top" title="Delete">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif

                                            <div class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-info d-inline"
                                                        data-toggle="modal"
                                                        title="Details"
                                                        onclick="suggestEditDetailsModal({{ $edit_request }})">
                                                    <i class="fa fa-eye" aria-hidden="true"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade suggest-edit-details-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Suggest An Edit Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Old</th>
                                        <th scope="col">Suggested</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><span class="font-weight-bold">Business Name:</span></td>
                                        <td><span id="old_organization_name"></span></td>
                                        <td><span id="suggested_organization_name"></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Is It Closed:</span></td>
                                        <td><span>No</span></td>
                                        <td><span id="is_it_closed"></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Temporarily Closed:</span></td>
                                        <td><span>No</span></td>
                                        <td><span id="temporarily_closed"></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Owner:</span></td>
                                        <td><span>Default</span></td>
                                        <td><span id="are_you_the_owner"></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Address:</span></td>
                                        <td><span id="old_organization_address"></span></td>
                                        <td><span id="organization_address"></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Phone Number:</span></td>
                                        <td><span id="old_organization_phone_number"></span></td>
                                        <td><span id="organization_phone_number"></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Website:</span></td>
                                        <td><span id="old_organization_website"></span></td>
                                        <td><span id="organization_website"></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Price List URL:</span></td>
                                        <td><span></span></td>
                                        <td><span id="price_list_url"></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Work Time:</span></td>
                                        <td><span id="old_organization_work_time"></span></td>
                                        <td><span id="organization_work_time"></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Description:</span></td>
                                        <td><span id="old_organization_description"></span></td>
                                        <td><span id="organization_description"></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="font-weight-bold">Message:</span></td>
                                        <td><span></span></td>
                                        <td><span id="message"></span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

    <script>
        function suggestEditDetailsModal(edit_request) {
            $('.suggest-edit-details-modal').modal('show');
            $('#old_organization_name').text(edit_request.organization.organization_name);
            $('#suggested_organization_name').text(edit_request.organization_name);
            $('#is_it_closed').text(edit_request.is_it_closed ? 'Yes' : 'No');
            $('#temporarily_closed').text(edit_request.temporarily_closed ? 'Yes' : 'No');
            $('#are_you_the_owner').text(edit_request.are_you_the_owner ? 'Yes' : 'No');
            $('#old_organization_address').text(edit_request.organization.organization_address);
            $('#organization_address').text(edit_request.organization_address);
            $('#old_organization_phone_number').text(edit_request.organization.organization_phone_number);
            $('#organization_phone_number').text(edit_request.organization_phone_number);
            $('#old_organization_website').text(edit_request.organization.organization_website);
            $('#organization_website').text(edit_request.organization_website);
            $('#price_list_url').text(edit_request.price_list_url);
            $('#old_organization_work_time').text(edit_request.organization.organization_work_time);
            $('#organization_work_time').text(edit_request.organization_work_time);
            $('#message').text(edit_request.message);
            $('#old_organization_description').text(edit_request.organization.organization_short_description);
            $('#organization_description').text(edit_request.organization_short_description);
        }
    </script>

    <script>
        $(document).on('click', 'button.approve-suggest-request', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to approve this suggested request?",
                icon: 'question',
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

        $(document).on('click', 'button.reject-suggested-request', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to reject this suggested request?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent('form').trigger('submit')
                }
            });
        });

        $(document).on('click', 'button.delete-suggested-request', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this suggested request?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent('form').trigger('submit')
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#suggest_edit_request_table').DataTable();
        });
    </script>
@endsection
