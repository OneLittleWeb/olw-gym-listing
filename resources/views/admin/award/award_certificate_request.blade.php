@extends('admin.master_admin')
@section('title', 'Award Certificate Request')
@section('content')
    <div class="container-fluid dashboard-inner-body-container">
        <div class="breadcrumb-content d-sm-flex align-items-center justify-content-between mb-4">
            <div class="section-heading">
                <h2 class="sec__title font-size-24 mb-0">Award Certificate Requests:</h2>
            </div>
            <ul class="list-items bread-list bread-list-2">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li>Award Certificate</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div class="block-card-body">
                        <div class="my-table table-responsive">
                            <table class="table align-items-center table-flush mb-0" id="award_certificates_table">
                                <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Business Name</th>
                                    <th>Affiliated With Business</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($award_certificate_requests as $key => $award_certificate_request)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td><a href="{{ route('city.wise.organization', ['city_slug' => $award_certificate_request->organization->city->slug, 'organization_slug' => $award_certificate_request->organization->slug]) }}" target="_blank">{{ $award_certificate_request->organization->organization_name }}</a></td>
                                        <td>
                                            @if($award_certificate_request->is_affiliated)
                                                <span class="text-success">Yes</span>
                                            @else
                                                <span class="text-danger">No</span>
                                            @endif
                                        </td>
                                        <td>{{$award_certificate_request->requested_user_name}}</td>
                                        <td>{{$award_certificate_request->requested_user_email}}</td>
                                        <td>
                                            @if($award_certificate_request->award_status == 0)
                                                <span
                                                    class="badge badge-warning">Pending</span>
                                            @elseif($award_certificate_request->award_status == 1)
                                                <span
                                                    class="badge badge-success">approved</span>
                                            @else
                                                <span
                                                    class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="width: 15%">
                                            @if($award_certificate_request->award_status == 0 )
                                                <form class="d-inline" method="post"
                                                      action="{{ route('admin.award.certificate.update', ['id' => $award_certificate_request->id, 'status' => 'approved']) }}">
                                                    @csrf
                                                    <button type="button"
                                                            class="btn btn-sm btn-primary approve-certificate-request"
                                                            data-toggle="tooltip" data-placement="top" title="Approve">
                                                        <i class="fa fa-check" aria-hidden="true"></i></button>
                                                </form>

                                                <form method="post"
                                                      action="{{ route('admin.award.certificate.update', ['id' => $award_certificate_request->id, 'status' => 'rejected']) }}"
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="button"
                                                            class="btn btn-sm btn-danger reject-certificate-request"
                                                            data-toggle="tooltip" data-placement="top" title="Reject"><i
                                                            class="fa fa-times" aria-hidden="true"></i></button>
                                                </form>
                                            @else
                                                <form method="post"
                                                      action="{{ route('admin.award.certificate.update', ['id' => $award_certificate_request->id, 'status' => 'deleted']) }}"
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="button"
                                                            class="btn btn-sm btn-danger delete-certificate-request"
                                                            data-toggle="tooltip" data-placement="top" title="Delete">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
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
@endsection
@section('js')
    <script>
        $(document).on('click', 'button.approve-certificate-request', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to approve this award certificate request? and the certificate has been sent to the requested business?",
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

        $(document).on('click', 'button.reject-certificate-request', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to reject this award certificate request?",
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

        $(document).on('click', 'button.delete-certificate-request', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this award certificate request?",
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
            $('#award_certificates_table').DataTable();
        });
    </script>
@endsection
