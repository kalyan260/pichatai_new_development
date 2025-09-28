@extends('layouts.guest')
@section('title',__('Login'))
@push('scripts-header')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush
@section('content')
  <style>
    .line{
        position: relative;
        height: 1px;
        width: 100%;
        margin: 36px 0;
        background-color: #d4d4d4;
    }
    .line::before{
        content: 'Or';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #FFF;
        color: #8b8b8b;
        padding: 0 15px;
    }
  </style>
    <h4>{{__("Let's keep going")}}</h4>
    <h6 class="fw-light">{{__('Sign in to continue')}}</h6>
    @include('layouts.alert')
    <form class="pt-3" method="POST" id="" action="{{route('login')}}">
        @csrf
        <div class="form-group">
          <input autofocus type="text" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" placeholder="{{__('Email')}}">
          {{-- @if ($errors->has('email'))
              <span class="text-danger">
                  {{ $errors->first('email') }}
              </span>
          @endif --}}
        </div>
        <div class="form-group">
          <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="{{__('Password')}}">      
          {{-- @if ($errors->has('password'))
              <span class="text-danger">
                  {{ $errors->first('password') }}
              </span>
          @endif --}}
        </div>
        <div class="mt-3">
          <button id="" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn text-uppercase">{{ __('Sign In') }}</button>
        </div>   
       
        <div class="mt-4 fw-light">
          {{__("Don't have an account?")}} <a href="{{route('register')}}" class="text-primary text-decoration-none">{{__('Create')}}</a>      
          @if (Route::has('password.request'))
              <a href="{{route('password.request')}}" class="auth-link text-black float-lg-end d-block d-lg-inline mt-2 mt-lg-0 text-decoration-none">{{__('Reset Password') }}</a>
          @endif
        </div>
    </form>
    {{-- Login With Social Media --}}
    <div class="line"></div>
    <div class="row">
      <div class="col-md-12">
          <div class="flex items-center justify-end mt-4 google-icon">
            <a class="btn btn-block social-login btn-primary btn-lg font-weight-medium auth-form-btn text-uppercase" href="{{ route('social.auth.google.index') }}" style="background: white; color: black; border: 1px solid black; padding: 10px; width: 100%; text-align: center; display: block; border-radius:3px;">
              <i class="fa fa-google fa-fw">
              </i> Login with Google
            </a>
          </div>
      </div>
      <div class="col-md-12">
        <div class="flex items-center justify-end mt-4 facebook-icon">
          <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn text-uppercase" href="{{ route('social.auth.facebook.index') }}" style="background: white; color: black; border: 1px solid black; padding: 10px; width: 100%; text-align: center; display: block; border-radius:5px;">
            <i class="fa fa-facebook fa-fw"></i> Login with Facebook
          </a>
        </div>
      </div>
      <div class="col-md-12">
        <div class="flex items-center justify-end mt-4 github-icon">
          <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn text-uppercase" href="{{ route('social.auth.github.index') }}" style="background: white; color: black; border: 1px solid black; padding: 10px; width: 100%; text-align: center; display: block; border-radius:5px;">
            <i class="fa fa-github"></i>  Login with Github
          </a>
        </div>
      </div>
      <div class="col-md-12">
        <div class="flex items-center justify-end mt-4 twitter-icon">
          <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn text-uppercase" href="{{ route('social.auth.twitter.index') }}" style="background: white; color: black; border: 1px solid black; padding: 10px; width: 100%; text-align: center; display: block; border-radius:5px;">
            <i class="fa fa-twitter"></i>  Login with Twitter
          </a>
        </div>
      </div>
      <div class="col-md-12">
        <div class="flex items-center justify-end mt-4 linkedin-icon">
          <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn text-uppercase" href="{{ route('social.auth.linkedin.index') }}" style="background: white; color: black; border: 1px solid black; padding: 10px; width: 100%; text-align: center; display: block; border-radius:5px;">
            <i class="fa fa-linkedin"></i>  Login with Linkedin
          </a>
        </div>
      </div>
    </div>
    {{-- Login With Social Media --}}
@endsection
