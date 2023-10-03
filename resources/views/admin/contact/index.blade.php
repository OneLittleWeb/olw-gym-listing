@extends('admin.master_admin')
@section('title', 'Contact US')
@section('content')
    <div class="container-fluid dashboard-inner-body-container">
        <div class="breadcrumb-content d-sm-flex align-items-center justify-content-between mb-4">
            <div class="section-heading">
{{--                <h2 class="sec__title font-size-24 mb-0">Howdy, {{ auth()->user()->name ?? 'Guest' }}</h2>--}}
                <h2 class="sec__title font-size-24 mb-0">Contact Us</h2>
            </div>
            <ul class="list-items bread-list bread-list-2">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li>Contacts</li>
            </ul>
        </div><!-- end breadcrumb-content -->
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div
                        class="block-card-header d-flex flex-wrap align-items-center justify-content-between px-4 border-bottom-0 pb-0">
                        <h2 class="widget-title pb-0">All Contacts</h2>
                    </div>
                    <div class="block-card-body">
                        <div class="my-table table-responsive">
                            <table class="table table-bordered data_table" id="contact_table">
                                <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end block-card-body -->
                </div><!-- end block-card -->
            </div><!-- end col-lg-7 -->
        </div><!-- end row -->
    </div><!-- end dashboard-inner-body-container -->
@endsection
@section('js')
    <script type="text/javascript">
        $(function () {
            $.fn.dataTable.ext.errMode = 'throw';
            let table = $('.data_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.contact.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'subject', name: 'subject'},
                    {data: 'message', name: 'message'},
                ]
            });

        });
    </script>
@endsection
