@extends('layouts.master')

@section('title')
    User Detail
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>User Detail</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Users</a></div>
        <div class="breadcrumb-item">User Detail</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">User Detail</h2>
      <p class="section-lead">
        On this page you can see user detail.
      </p>

      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
                <h4>User Detail Form</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group row align-items-center">
                                    <label for="name" class="form-control-label col-sm-3 text-md-right required">Name</label>
                                    <div class="col-sm-12 col-md-7">
                                        {{ $user->name ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label for="email" class="form-control-label col-sm-3 text-md-right required">E-mail Address</label>
                                    <div class="col-sm-12 col-md-7">
                                        {{ $user->email ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label for="role" class="form-control-label col-sm-3 text-md-right required">Role</label>
                                    <div class="col-sm-12 col-md-7">
                                        @foreach ($roles as $roleKey => $roleValue)
                                           {{ ($roleKey == $user->role) ? $roleValue : "" }}
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection