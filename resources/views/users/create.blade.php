@extends('layouts.master')

@section('title')
Create User
@endsection

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Create User</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Manage Users</a></div>
        <div class="breadcrumb-item">Create User</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Create User</h2>
      <p class="section-lead">
        On this page you can create a user.
      </p>

      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    <strong>{{ session()->get('success') }}</strong>
                    <button type="button" class="close " data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    <strong>{{ session()->get('error') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
          <div class="card">
            <div class="card-header">
                <h4>Create User Form</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row mt-4">
                            <div class="col-12">
                                <form method="post" action="{{ route('users.store') }}">
                                    @csrf
                                    <div class="form-group row align-items-center">
                                        <label for="name" class="form-control-label col-sm-3 text-md-right required">Name</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required="required">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label for="email" class="form-control-label col-sm-3 text-md-right required">E-mail Address</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required="required">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label for="password" class="form-control-label col-sm-3 text-md-right required">Password</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required="required">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label for="role" class="form-control-label col-sm-3 text-md-right required">Role</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select name="role" id="role" class="form-control selectric @error('role') is-invalid @enderror" required="required">
                                                <option value=""></option>
                                                @foreach ($roles as $roleKey => $roleValue)
                                                    <option value="{{ $roleKey }}">{{ $roleValue }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label class="form-control-label col-sm-3 text-md-right"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button class="btn btn-primary btn-icon icon-left" type="submit">
                                                <i class="fas fa-plus-circle"></i> Create
                                            </button>
                                            <button class="btn btn-warning btn-icon icon-left" type="reset">
                                                <i class="fas fa-redo-alt"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
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