@extends('layouts.master')
@section('title', config('app.name') . " THE Local Business Directory | States")
@section('meta_description', "Browse near by all gyms.")
@section('meta_keywords',"USA, gymnearx, gymnearme")
@section('content')
    <section class="category-area section--padding margin-top-40px">
        <div class="card">
            <div class="card-body">
                @forelse($organizations as $organization)
                    <p>{{ $organization->organization_name }} - {{ $organization->state->name }} - {{ $organization->city->name }}
                        - {{ $organization->distance }}</p>
                @empty
                    <p>No gyms found.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
