@extends('admin.master_admin')
@section('title', 'Plans')
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
                <li>Plans</li>
            </ul>
        </div><!-- end breadcrumb-content -->
        <div class="row">
            <div class="col-md-12">
                <div class="block-card dashboard-card mb-4 px-0">
                    <div
                        class="block-card-header d-flex flex-wrap align-items-center justify-content-between px-4 border-bottom-0 pb-0">
                        <h2 class="widget-title pb-0">All Plans</h2>
                        <a href="{{route('admin.plan.create')}}" class="btn btn-info">Add New Plan<i
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
                                    <th>Stripe Id</th>
                                    <th>Price</th>
                                    <th>Abbreviation</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($plans as $key => $plan)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{Str::title($plan->name)}}</td>
                                        <td>{{$plan->slug}}</td>
                                        <td>{{$plan->stripe_id}}</td>
                                        <td>${{$plan->price}}</td>
                                        <td>{{$plan->abbreviation}}</td>
                                        <td>
                                            <form action="{{route('admin.plan.destroy',$plan->id)}}"
                                                  onsubmit="return confirm('Do you really want to delete?');"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{route('admin.plan.edit',$plan->id)}}"
                                                   class="btn btn-sm btn-primary">Edit</a>
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
                            {{$plans->links()}}
                </div><!-- end block-card -->
            </div><!-- end col-lg-7 -->
        </div><!-- end row -->
    </div><!-- end dashboard-inner-body-container -->
@endsection
@section('js')

@endsection
