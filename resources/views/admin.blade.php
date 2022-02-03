@extends('layouts.auth')

    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        Hi Hi there, Boss Hi there, {{ \Auth::guard('admin')->user()->name }}
                        or {{ auth('admin')->user()->name }}!
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
