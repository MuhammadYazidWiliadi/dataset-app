@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="text-center">
                        <h3>Selamat Datang di Aplikasi Dataset</h3>
                        <p class="lead">Kelola dataset Anda dengan mudah</p>
                        
                        <div class="mt-4">
                            <a href="{{ route('datasets.index') }}" class="btn btn-primary btn-lg me-2">
                                <i class="fas fa-database"></i> Kelola Dataset
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-chart-bar"></i> Lihat Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection