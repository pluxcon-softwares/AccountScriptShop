@extends('user.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="row justify-content-center mt-3">

        @include('admin.partials.top_widgets')
        
        <div class="col-md-12">
            <div class="card card-blue">
                <div class="card-header">
                    <h3 class="card-title">All Site Rules</h3>
                </div>
                <div class="card-body">
                    @if (count($rules) <= 0)
                        <p class="card-text">No Rules Available</p>
                    @else
                        @foreach ($rules as $rule)
                        <div class="callout callout-danger">
                            <p>{{ $rule->rule }}</p>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
