@extends('admin.master_admin')
@section('title', 'Organizations')
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
                <li>Organizations</li>
            </ul>
        </div><!-- end breadcrumb-content -->
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div
                        class="block-card-header d-flex flex-wrap align-items-center justify-content-between px-4 border-bottom-0 pb-0">
                        <h2 class="widget-title pb-0">All Organizations</h2>
                        <a href="{{route('admin.organization.create')}}" class="btn btn-info">Add New Organization<i
                                class="la la-plus-circle ml-1"></i></a>
                    </div>
                    <div class="block-card-body">
                        <div class="my-table table-responsive">
                            <table class="table align-items-center table-flush mb-0" id="category_table">
                                <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Claimed?</th>
                                    <th>Last Updated on</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($organizations as $key => $organization)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{\Illuminate\Support\Str::title($organization->organization_name)}}</td>
                                        <td>{{$organization->slug}}</td>
                                        <td>{{$organization->is_claimed == 0 ? "No" : "Yes"}}</td>
                                        <td>{{\Carbon\Carbon::parse($organization->updated_at)->diffForHumans()}}</td>
                                        <td>
                                            <form action="{{route('admin.category.destroy',$organization->id)}}"
                                                  onsubmit="return confirm('Do you really want to delete?');"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                   class="btn btn-sm btn-primary"
                                                   data-toggle="modal"
                                                   data-target="#editOrganization"
                                                   data-category="{{$organization->name}}"
                                                   data-icon="{{$organization->icon}}"
                                                   data-background="{{$organization->background}}"
                                                   data-background_image="{{$organization->background_image}}"
                                                   @if(!is_null($organization->meta))
                                                   data-metakeywords="{{json_decode($organization->meta)->meta_keywords}}"
                                                   data-metadescrition="{{json_decode($organization->meta)->meta_description}}"
                                                   @endif
                                                   data-category_id="{{$organization->id}}">Edit</button>
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
                            {{$organizations->links()}}
                </div><!-- end block-card -->
            </div><!-- end col-lg-7 -->
        </div><!-- end row -->
    </div><!-- end dashboard-inner-body-container -->
@endsection
@section('js')

@endsection
