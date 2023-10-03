@extends('admin.master_admin')
@section('title', 'Business')
@section('content')
    <div class="container-fluid dashboard-inner-body-container">
        <div class="breadcrumb-content d-sm-flex align-items-center justify-content-between mb-4">
            <div class="section-heading">
                <h2 class="sec__title font-size-24 mb-0">All Business - <a href="{{ route('admin.all.reviews') }}">All Reviews</a></h2>
            </div>
            <ul class="list-items bread-list bread-list-2">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li>Reviews</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div
                        class="block-card-header d-flex flex-wrap align-items-center justify-content-between px-4 border-bottom-0 pb-0">
                        <h2 class="widget-title pb-0">All Business</h2>
                    </div>
                    <div class="block-card-body">
                        <div class="my-table table-responsive">
                            <table class="table table-bordered data_table" id="organization_table">
                                <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Total Reviews</th>
                                    <th>Rate Stars</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
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
    <script type="text/javascript">
        $(function () {
            $.fn.dataTable.ext.errMode = 'throw';
            $('#organization_table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.reviews.business') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'organization_name', name: 'organization_name'},
                    {data: 'reviews_total_count', name: 'reviews_total_count'},
                    {data: 'rate_stars', name: 'rate_stars'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endsection
