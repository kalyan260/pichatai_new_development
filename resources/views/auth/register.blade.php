@extends('layouts.guest')
@section('title',__('Sign Up'))
@push('scripts-header')
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=_turnstileCb" async defer></script>
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
    <h4>{{__("New here?")}}</h4>
    <h6 class="fw-light">{{__('Signing up only takes a minute')}}</h6>
    @include('layouts.alert')   
    <form class="pt-3" method="POST" id="register-form">
      <div class="form-group">
        <input autofocus type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name') }}" placeholder="{{__('Full Name')}} *">
      </div>  
      <div class="form-group">
        <input type="text" class="form-control form-control-lg" id="email" name="email" value="{{ old('email') }}" placeholder="{{__('Email')}} *">
      </div>
      <div class="form-group">
        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="{{__('Password')}} *"> 
      </div>
      <div class="form-group">
        <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="{{__('Confirm Password')}} *"> 
      </div>
      
      <div class="mb-4">
        <div class="form-check">
          <label class="text-muted">
            <input type="checkbox" class="" name="terms" id="terms" value="1">
            {!!__('I agree to all the :terms',['terms'=>'<a class="text-decoration-none">'.__('Terms & Conditions').'</a>'])!!}
          </label>
        </div>
      </div>
      <div class="checkbox mb-3">
        <!-- The Turnstile widget will be injected in the following div. -->
        <div id="myWidget"></div>
        <!-- end. -->
      </div>
      <div class="mt-3">
        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn text-uppercase" id="form-submit-button">{{__('Sign Up')}}</button>
      </div>
      <div class="mt-4 fw-light">
        {{__('Already have an account?')}} <a href="{{route('login')}}" class="text-primary text-decoration-none">{{__('Sign In')}}</a>
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

@push('scripts-footer')
<script>
  // This function is called when the Turnstile script is loaded and ready to be used.
  // The function name matches the "onload=..." parameter.
  function _turnstileCb() {
      console.debug('_turnstileCb called');
  
      turnstile.render('#myWidget', {
        sitekey: '0x4AAAAAAAEsBvqaAbH-QJtA',
        theme: 'light',
      });
  }
  </script>
    <script src="{{ asset('assets/js/pages/auth/auth.register.js') }}"></script>
@endpush
