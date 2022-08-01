@extends('backend.layouts.app')

@section('title')
    {{ __('Verify Your Email Address') }}
@endsection

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Email Verification</h1>
                <div class="section-header-breadcrumb">
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-sm-12">
                        @if (session('resent'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> <strong>Success!</strong> {{ __('A fresh verification link has been sent to your email address.') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="https://freepngimg.com/thumb/android/64743-mobile-phones-client-mail-android-email.png" class="rounded" alt="..." width="200" height="200">
                                </div>
                                <div class="text-center my-2 pt-1">
                                    <h4>Verify Your Email Address</h4>
                                </div>
                                <div class="pt-2 text-center">We've sent an email to <b>{{ auth()->user()->email }}</b> to verify your email address and activate your account. The link in the email will expire in 24 hours.</div>
                                <div class="pt-1 text-center">
                                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Click here to request another</button>
                                    </form>
                                    if you did not receive an email. {{-- <a href="" class="btn btn-link p-0 m-0 align-baseline">Click here</a> if you would like to change the email address you signed up with. --}}
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
