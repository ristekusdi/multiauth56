@extends('layouts.web')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    Hi, {{ \Auth::guard('imissu-web')->user()->name }}
                    or {{ auth('imissu-web')->user()->name }}!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
