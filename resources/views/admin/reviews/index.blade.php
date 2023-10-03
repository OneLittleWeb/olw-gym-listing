@extends('admin.master_admin')
@section('title', 'Business')
@section('content')
    <div class="container-fluid dashboard-inner-body-container">
        <div class="breadcrumb-content d-sm-flex align-items-center justify-content-between mb-4">
            <div class="section-heading">
                <h2 class="sec__title font-size-24 mb-0">Howdy, {{ auth()->user()->name ?? 'Guest' }}</h2>
            </div>
            <ul class="list-items bread-list bread-list-2">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li><a href="{{route('admin.reviews.business')}}">Reviews Businesses</a></li>
                <li>Reviews</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div
                        class="block-card-header d-flex flex-wrap align-items-center justify-content-between px-4 border-bottom-0 pb-0">
                        <h2 class="widget-title pb-0">Reviews -> <span class="text-primary"><a
                                    href="{{ route('city.wise.organization', ['city_slug' => $business->city->slug, 'organization_slug' => $business->slug]) }}"
                                    target="_blank">{{ $business->organization_name }}</a></span></h2>
                    </div>
                    <div class="block-card-body">
                        <div class="my-table table-responsive">
                            <table class="table table-bordered data_table" id="organization_reviews_table">
                                <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Reviewer Name</th>
                                    <th>Review</th>
                                    <th>Rate Stars</th>
                                    <th>Review Date</th>
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
            $('#organization_reviews_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.reviews', $business->organization_guid) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'reviewer_name', name: 'reviewer_name'},
                    {data: 'review_text_original', name: 'review_text_original'},
                    {data: 'review_rate_stars', name: 'review_rate_stars'},
                    {data: 'review_date', name: 'review_date'}
                ]
            });
        });
    </script>
@endsection
