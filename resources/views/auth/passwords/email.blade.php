@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
          <div class="login-brand">
            <img src="backend/assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
          </div>
          @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif
          <div class="card card-primary">
            <div class="card-header"><h4>Forgot Password</h4></div>

            <div class="card-body">
              <p class="text-muted">We will send a link to reset your password</p>
              <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                  <label for="email">Email</label>
                  <input id="email" type="email" class="form-control" name="email" tabindex="1" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    {{ __('Send Password Reset Link') }}
                  </button>
                </div>
              </form>
            </div>
          </div>
          <div class="simple-footer">
            Copyright &copy; Stisla 2018
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
