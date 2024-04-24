@extends('layouts.app')

@section('content')

<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Select Plane:</div>
                <div class="card-body">

                    <div class="row">
                        @foreach($plans as $plan)

                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    ${{ $plan->price }}/Mo
                                </div>

                                <div class="card-body">

                                    <h5 class="card-title">{{ $plan->name }}</h5>

                                    <p class="card-text">{{ $plan->description }}</p>

                                    <a href="{{ route('plans.show', $plan->slug) }}" class="btn btn-primary pull-right{{ in_array($plan->stripe_plan, $alreadySubscribe) ? ' disabled ' : '' }}">Choose</a>
                                    <a href="{{ route('subscription.cancel',$plan->name) }}" class="btn btn-danger pull-right{{ in_array($plan->stripe_plan, $alreadySubscribe) ? '' : ' disabled ' }}">Cancel</a>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
