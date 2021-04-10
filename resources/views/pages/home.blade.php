@extends('layout.backEnd')
@section('container')
    <div class="container">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    <h3>Dashboard</h3>
                </div>
                <div class="card-body">
                    <h4>Selamat datang di halaman dashboard, <strong>{{ Auth::user()->name }}</strong></h4>
                </div>
            </div>
        </div>
    </div>
@endsection